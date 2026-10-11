<?php

namespace App\Exceptions\Gemini;

class GeminiResponseException extends GeminiException
{
    public function __construct(string $message = 'Format respons AI tidak valid atau tidak dapat diproses.')
    {
        parent::__construct($message);
    }
}
