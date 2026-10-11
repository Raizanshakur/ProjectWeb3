<?php

namespace App\Services\Gemini;

use App\Exceptions\Gemini\GeminiApiKeyMissingException;
use App\Exceptions\Gemini\GeminiQuotaExceededException;
use App\Exceptions\Gemini\GeminiResponseException;
use App\Exceptions\Gemini\GeminiTimeoutException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiGateway implements GeminiGatewayInterface
{
    protected ?string $apiKey;
    protected string $model;
    protected string $visionModel;
    protected string $chatModel;
    protected int $timeout;

    public function __construct(
        ?string $apiKey = null,
        ?string $model = null,
        ?int $timeout = null,
        ?string $chatModel = null
    ) {
        $this->apiKey = $apiKey ?? config('services.gemini.api_key');
        $this->visionModel = $model ?? config('services.gemini.vision_model', 'gemini-3.8-flash');
        $this->model = $this->visionModel;
        $this->chatModel = $chatModel ?? config('services.gemini.chat_model', 'gemini-3.8-flash');
        $this->timeout = $timeout ?? (int) config('services.gemini.timeout', 25);
    }

    /**
     * {@inheritdoc}
     */
    public function analyzeFoodImage(string $imageBytes, string $mimeType): array
    {
        if (empty($this->apiKey)) {
            throw new GeminiApiKeyMissingException();
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        $prompt = "Anda adalah asisten analisis nutrisi makanan anak. Analisis gambar ini secara objektif. Tentukan apakah gambar adalah makanan (is_food: true/false). Jika makanan, perkirakan nama makanan dalam bahasa Indonesia, bahan-bahan yang terlihat, porsi yang tampak, serta estimasi kalori dan makronutrien (protein, karbohidrat, lemak, serat dalam gram). Jika tidak dapat dipastikan atau bahan tersembunyi/tidak jelas, berikan nilai null pada angka nutrisi terkait dan jelaskan alasannya pada uncertainty_note. Jangan mengarang angka yang tidak berdasar.";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt,
                        ],
                        [
                            'inlineData' => [
                                'mimeType' => $mimeType,
                                'data' => base64_encode($imageBytes),
                            ],
                        ],
                    ],
                ],
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'responseSchema' => [
                    'type' => 'OBJECT',
                    'properties' => [
                        'is_food' => ['type' => 'BOOLEAN'],
                        'food_name' => ['type' => 'STRING'],
                        'visible_ingredients' => [
                            'type' => 'ARRAY',
                            'items' => ['type' => 'STRING'],
                        ],
                        'portion_description' => ['type' => 'STRING'],
                        'estimated_calories' => ['type' => 'NUMBER'],
                        'estimated_protein_g' => ['type' => 'NUMBER'],
                        'estimated_carbohydrates_g' => ['type' => 'NUMBER'],
                        'estimated_fat_g' => ['type' => 'NUMBER'],
                        'estimated_fiber_g' => ['type' => 'NUMBER'],
                        'uncertainty_note' => ['type' => 'STRING'],
                        'analysis_note' => ['type' => 'STRING'],
                    ],
                    'required' => ['is_food'],
                ],
            ],
        ];

        $startTime = microtime(true);

        try {
            // Retry hingga 2 kali hanya untuk gangguan koneksi sementara
            $response = Http::timeout($this->timeout)
                ->retry(2, 200, function ($exception, $request) {
                    return $exception instanceof ConnectionException;
                }, throw: false)
                ->withHeaders([
                    'x-goog-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);
        } catch (ConnectionException $e) {
            $duration = round(microtime(true) - $startTime, 3);
            Log::warning('Gemini vision connection timeout', [
                'model' => $this->model,
                'duration_sec' => $duration,
            ]);
            throw new GeminiTimeoutException('Koneksi ke layanan AI timeout atau terputus.', 0, $e);
        }

        $duration = round(microtime(true) - $startTime, 3);

        if ($response->status() === 429) {
            Log::warning('Gemini vision 429 quota exceeded', [
                'model' => $this->model,
                'duration_sec' => $duration,
            ]);
            throw new GeminiQuotaExceededException();
        }

        if ($response->status() === 408 || $response->status() === 504) {
            throw new GeminiTimeoutException();
        }

        if (! $response->successful()) {
            Log::error('Gemini vision request failed', [
                'status' => $response->status(),
                'model' => $this->model,
                'duration_sec' => $duration,
            ]);
            throw new GeminiResponseException('Layanan AI mengembalikan status error: ' . $response->status());
        }

        Log::info('Gemini vision analysis completed', [
            'status' => 200,
            'model' => $this->model,
            'duration_sec' => $duration,
        ]);

        $responseData = $response->json();
        $rawText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (! $rawText) {
            throw new GeminiResponseException('Respons AI tidak memuat kandidat teks yang valid.');
        }

        $parsed = json_decode($rawText, true);
        if (! is_array($parsed) || json_last_error() !== JSON_ERROR_NONE) {
            throw new GeminiResponseException('Gagal mengurai respons JSON dari AI: ' . json_last_error_msg());
        }

        return $this->sanitizeStructuredOutput($parsed);
    }

    /**
     * Sanitize and validate structured output from the model.
     *
     * @param array $data
     * @return array
     */
    protected function sanitizeStructuredOutput(array $data): array
    {
        $isFood = isset($data['is_food']) ? (bool) $data['is_food'] : false;

        $toFloatOrNull = function ($val, $max = 1000) {
            if ($val === null || $val === '') {
                return null;
            }
            if (! is_numeric($val)) {
                return null;
            }
            $float = (float) $val;
            return ($float >= 0 && $float <= $max) ? round($float, 2) : null;
        };

        if (! $isFood) {
            return [
                'is_food' => false,
                'food_name' => null,
                'visible_ingredients' => [],
                'portion_description' => null,
                'estimated_calories' => null,
                'estimated_protein_g' => null,
                'estimated_carbohydrates_g' => null,
                'estimated_fat_g' => null,
                'estimated_fiber_g' => null,
                'uncertainty_note' => (! empty($data['uncertainty_note']) && is_string($data['uncertainty_note']))
                    ? trim($data['uncertainty_note'])
                    : 'Objek pada gambar tidak teridentifikasi sebagai makanan.',
                'analysis_note' => null,
                'model_used' => $this->model,
            ];
        }

        $ingredients = [];
        if (isset($data['visible_ingredients']) && is_array($data['visible_ingredients'])) {
            foreach ($data['visible_ingredients'] as $ing) {
                if (is_string($ing) && trim($ing) !== '') {
                    $ingredients[] = trim($ing);
                }
            }
        }

        return [
            'is_food' => true,
            'food_name' => (! empty($data['food_name']) && is_string($data['food_name'])) ? trim($data['food_name']) : 'Makanan Tanpa Nama',
            'visible_ingredients' => $ingredients,
            'portion_description' => (! empty($data['portion_description']) && is_string($data['portion_description'])) ? trim($data['portion_description']) : null,
            'estimated_calories' => $toFloatOrNull($data['estimated_calories'] ?? null, 10000),
            'estimated_protein_g' => $toFloatOrNull($data['estimated_protein_g'] ?? null, 1000),
            'estimated_carbohydrates_g' => $toFloatOrNull($data['estimated_carbohydrates_g'] ?? null, 1000),
            'estimated_fat_g' => $toFloatOrNull($data['estimated_fat_g'] ?? null, 1000),
            'estimated_fiber_g' => $toFloatOrNull($data['estimated_fiber_g'] ?? null, 500),
            'uncertainty_note' => (! empty($data['uncertainty_note']) && is_string($data['uncertainty_note'])) ? trim($data['uncertainty_note']) : null,
            'analysis_note' => (! empty($data['analysis_note']) && is_string($data['analysis_note'])) ? trim($data['analysis_note']) : null,
            'model_used' => $this->model,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generateChatResponse(
        string $userMessage,
        array $conversationHistory = [],
        ?string $systemInstruction = null
    ): string {
        if (empty($this->apiKey)) {
            throw new GeminiApiKeyMissingException();
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->chatModel}:generateContent";

        $contents = [];
        foreach ($conversationHistory as $turn) {
            if (! empty($turn['content']) && is_string($turn['content'])) {
                $role = ($turn['role'] ?? 'user') === 'model' ? 'model' : 'user';
                $contents[] = [
                    'role' => $role,
                    'parts' => [
                        ['text' => $turn['content']],
                    ],
                ];
            }
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage],
            ],
        ];

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
            ],
        ];

        if (! empty($systemInstruction)) {
            $payload['systemInstruction'] = [
                'parts' => [
                    ['text' => $systemInstruction],
                ],
            ];
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout($this->timeout)
                ->retry(2, 200, function ($exception, $request) {
                    return $exception instanceof ConnectionException;
                }, throw: false)
                ->withHeaders([
                    'x-goog-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);
        } catch (ConnectionException $e) {
            $duration = round(microtime(true) - $startTime, 3);
            Log::warning('Gemini chat connection timeout', [
                'model' => $this->chatModel,
                'duration_sec' => $duration,
            ]);
            throw new GeminiTimeoutException();
        }

        $duration = round(microtime(true) - $startTime, 3);

        if ($response->status() === 429) {
            Log::warning('Gemini chat quota exceeded (429)', [
                'model' => $this->chatModel,
                'duration_sec' => $duration,
            ]);
            throw new GeminiQuotaExceededException();
        }

        if (! $response->successful()) {
            Log::error('Gemini chat request failed', [
                'model' => $this->chatModel,
                'status' => $response->status(),
                'duration_sec' => $duration,
            ]);
            throw new GeminiResponseException('Layanan Gemini AI gagal merespons permintaan chat (HTTP ' . $response->status() . ').');
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (! is_string($text) || trim($text) === '') {
            throw new GeminiResponseException('Respons dari model Gemini kosong atau tidak valid.');
        }

        Log::info('Gemini chat request succeeded', [
            'model' => $this->chatModel,
            'duration_sec' => $duration,
            'status' => 200,
        ]);

        return trim($text);
    }
}
