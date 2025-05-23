<?php

namespace App\Http\Controllers;

use App\Contracts\TranslatorInterface;

class GreetingController extends Controller
{
    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function greet()
    {
        return response()->json([
            'message' => $this->translator->translate('greeting'),
        ]);
    }
}

