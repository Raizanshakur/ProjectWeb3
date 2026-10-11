<?php

namespace App\Exceptions\Gemini;

class GeminiTimeoutException extends GeminiException
{
    public function __construct(string $message = 'Waktu permintaan analisis ke AI habis (timeout). Silakan periksa koneksi dan coba lagi.')
    {
        parent::__construct($message);
    }
}
