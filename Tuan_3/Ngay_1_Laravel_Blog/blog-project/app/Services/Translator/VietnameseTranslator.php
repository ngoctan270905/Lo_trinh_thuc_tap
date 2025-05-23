<?php
namespace App\Services\Translator;

use App\Contracts\TranslatorInterface;

class VietnameseTranslator implements TranslatorInterface
{
    public function translate(string $key): string
    {
        $translations = [
            'greeting' => 'Xin chào',
            // Thêm các key khác nếu muốn
        ];

        return $translations[$key] ?? $key;
    }
}
