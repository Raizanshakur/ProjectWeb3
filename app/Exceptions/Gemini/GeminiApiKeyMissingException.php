<?php

namespace App\Exceptions\Gemini;

class GeminiApiKeyMissingException extends GeminiException
{
    public function __construct(string $message = 'Kunci API Gemini belum dikonfigurasi pada server.')
    {
        parent::__construct($message);
    }
}
