<?php

namespace App\Exceptions\Gemini;

class GeminiQuotaExceededException extends GeminiException
{
    public function __construct(string $message = 'Batas kuota layanan Gemini tercapai (429). Silakan coba lagi beberapa saat lagi.')
    {
        parent::__construct($message);
    }
}
