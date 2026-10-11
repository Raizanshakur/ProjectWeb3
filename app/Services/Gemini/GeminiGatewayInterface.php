<?php

namespace App\Services\Gemini;

interface GeminiGatewayInterface
{
    /**
     * Analyze a food image and return structured analysis data.
     *
     * @param string $imageBytes Raw binary content of the image
     * @param string $mimeType e.g. image/jpeg, image/png, image/webp
     * @return array{
     *     is_food: bool,
     *     food_name: ?string,
     *     visible_ingredients: ?array<string>,
     *     portion_description: ?string,
     *     estimated_calories: ?float,
     *     estimated_protein_g: ?float,
     *     estimated_carbohydrates_g: ?float,
     *     estimated_fat_g: ?float,
     *     estimated_fiber_g: ?float,
     *     uncertainty_note: ?string,
     *     analysis_note: ?string,
     *     model_used: string,
     * }
     *
     * @throws \App\Exceptions\Gemini\GeminiException
     */
    public function analyzeFoodImage(string $imageBytes, string $mimeType): array;

    /**
     * Generate chat response from Gemini using conversation history and system instruction.
     *
     * @param string $userMessage The user's input question
     * @param array<array{role: string, content: string}> $conversationHistory Previous user & model exchanges
     * @param string|null $systemInstruction Medical/educational prompt instructions
     * @return string Generated response text
     *
     * @throws \App\Exceptions\Gemini\GeminiException
     */
    public function generateChatResponse(
        string $userMessage,
        array $conversationHistory = [],
        ?string $systemInstruction = null
    ): string;
}
