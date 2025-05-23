<?php
namespace App\Services\Translator;

use App\Contracts\TranslatorInterface;

class EnglishTranslator implements TranslatorInterface
{
    public function translate(string $key): string
    {
        $translations = [
            'greeting' => 'Hello',
            // Thêm các key khác nếu muốn
        ];

        return $translations[$key] ?? $key;
    }
}
