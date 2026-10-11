<?php

namespace App\Services\Gemini;

use App\Exceptions\Gemini\GeminiApiKeyMissingException;
use App\Exceptions\Gemini\GeminiQuotaExceededException;
use App\Exceptions\Gemini\GeminiResponseException;
use App\Exceptions\Gemini\GeminiTimeoutException;

class FakeGeminiGateway implements GeminiGatewayInterface
{
    protected ?\Closure $handler = null;
    protected array $calls = [];

    /**
     * Set a custom callback handler for analyzeFoodImage.
     */
    public function setHandler(\Closure $handler): self
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * Fake a successful food analysis response.
     */
    public function fakeSuccess(array $overrides = []): self
    {
        $this->handler = function (string $imageBytes, string $mimeType) use ($overrides) {
            return array_merge([
                'is_food' => true,
                'food_name' => 'Bubur Ayam Wortel',
                'visible_ingredients' => ['Beras', 'Daging Ayam', 'Wortel', 'Kuah Kaldu'],
                'portion_description' => '1 mangkuk sedang (sekitar 200g)',
                'estimated_calories' => 240.0,
                'estimated_protein_g' => 12.5,
                'estimated_carbohydrates_g' => 32.0,
                'estimated_fat_g' => 6.0,
                'estimated_fiber_g' => 2.5,
                'uncertainty_note' => 'Kandungan minyak dan kaldu tidak dapat dipastikan dengan presisi dari foto.',
                'analysis_note' => 'Cocok untuk sarapan anak usia balita.',
                'model_used' => 'gemini-3.8-flash',
            ], $overrides);
        };

        return $this;
    }

    /**
     * Fake a non-food image result.
     */
    public function fakeNotFood(string $reason = 'Gambar yang diunggah tidak terdeteksi sebagai makanan.'): self
    {
        $this->handler = function () use ($reason) {
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
                'uncertainty_note' => $reason,
                'analysis_note' => null,
                'model_used' => 'gemini-3.8-flash',
            ];
        };

        return $this;
    }

    /**
     * Fake quota exceeded (429).
     */
    public function fakeQuotaExceeded(): self
    {
        $this->handler = function () {
            throw new GeminiQuotaExceededException();
        };

        return $this;
    }

    /**
     * Fake request timeout.
     */
    public function fakeTimeout(): self
    {
        $this->handler = function () {
            throw new GeminiTimeoutException();
        };

        return $this;
    }

    /**
     * Fake missing API key.
     */
    public function fakeMissingApiKey(): self
    {
        $this->handler = function () {
            throw new GeminiApiKeyMissingException();
        };

        return $this;
    }

    /**
     * Fake invalid response / JSON decode failure.
     */
    public function fakeResponseException(string $message = 'Format respons AI tidak valid'): self
    {
        $this->handler = function () use ($message) {
            throw new GeminiResponseException($message);
        };

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function analyzeFoodImage(string $imageBytes, string $mimeType): array
    {
        $this->calls[] = [
            'imageBytesLength' => strlen($imageBytes),
            'mimeType' => $mimeType,
        ];

        if ($this->handler) {
            return ($this->handler)($imageBytes, $mimeType);
        }

        return [
            'is_food' => true,
            'food_name' => 'Nasi Tim Ayam',
            'visible_ingredients' => ['Beras', 'Ayam'],
            'portion_description' => '1 porsi',
            'estimated_calories' => 200.0,
            'estimated_protein_g' => 10.0,
            'estimated_carbohydrates_g' => 30.0,
            'estimated_fat_g' => 5.0,
            'estimated_fiber_g' => 2.0,
            'uncertainty_note' => null,
            'analysis_note' => null,
            'model_used' => 'gemini-3.8-flash',
        ];
    }

    /**
     * Get recorded calls.
     */
    public function getCalls(): array
    {
        return $this->calls;
    }

    /**
     * Call count.
     */
    public function callCount(): int
    {
        return count($this->calls);
    }

    // ── Chat Mocking ──────────────────────────────────────────

    protected ?\Closure $chatHandler = null;
    protected array $chatCalls = [];
    protected ?\Throwable $chatException = null;

    /**
     * Configure fake success chat response.
     */
    public function fakeChatSuccess(?string $response = null): self
    {
        $reply = $response ?? 'Kebutuhan kalori dan gizi harian anak bervariasi sesuai usia dan aktivitas. Pastikan memberikan makanan beragam dan bergizi seimbang.';
        $this->chatHandler = function () use ($reply) {
            return $reply;
        };

        return $this;
    }

    /**
     * Set a custom callback handler for chat requests.
     */
    public function fakeChatHandler(\Closure $handler): self
    {
        $this->chatHandler = $handler;
        return $this;
    }

    /**
     * Fake chat throwing quota exceeded (429).
     */
    public function fakeChatQuotaExceeded(): self
    {
        $this->chatException = new GeminiQuotaExceededException();
        return $this;
    }

    /**
     * Fake chat throwing timeout.
     */
    public function fakeChatTimeout(): self
    {
        $this->chatException = new GeminiTimeoutException();
        return $this;
    }

    /**
     * Fake chat throwing missing API key.
     */
    public function fakeChatMissingApiKey(): self
    {
        $this->chatException = new GeminiApiKeyMissingException();
        return $this;
    }

    /**
     * Fake chat throwing response exception.
     */
    public function fakeChatResponseException(string $message = 'Format respons AI tidak valid'): self
    {
        $this->chatException = new GeminiResponseException($message);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function generateChatResponse(
        string $userMessage,
        array $conversationHistory = [],
        ?string $systemInstruction = null
    ): string {
        $this->chatCalls[] = [
            'message' => $userMessage,
            'history' => $conversationHistory,
            'systemInstruction' => $systemInstruction,
        ];

        if ($this->chatException) {
            throw $this->chatException;
        }

        if ($this->chatHandler) {
            return ($this->chatHandler)($userMessage, $conversationHistory, $systemInstruction);
        }

        return 'Halo! Saya NutriBot, asisten AI edukasi nutrisi GrowCare. Nutrisi seimbang sangat penting untuk mendukung tumbuh kembang optimal anak Anda.';
    }

    /**
     * Get recorded chat calls.
     */
    public function getChatCalls(): array
    {
        return $this->chatCalls;
    }

    /**
     * Get chat call count.
     */
    public function chatCallCount(): int
    {
        return count($this->chatCalls);
    }
}
