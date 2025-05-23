<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\TranslatorInterface;
use App\Services\Translator\VietnameseTranslator;
use App\Services\Translator\EnglishTranslator;

class TranslatorServiceProvider extends ServiceProvider
{
    public function register()
{
    $locale = config('app.locale');

    $this->app->bindIf(\App\Contracts\TranslatorInterface::class, function () use ($locale) {
        if ($locale === 'vi') {
            return new \App\Services\Translator\VietnameseTranslator();
        }
        return new \App\Services\Translator\EnglishTranslator();
    }, true); // true = singleton
}

}
