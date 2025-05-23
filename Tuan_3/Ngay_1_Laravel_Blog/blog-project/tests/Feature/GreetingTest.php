<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GreetingTest extends TestCase
{
    public function test_greeting_in_vietnamese()
    {
        config(['app.locale' => 'vi']);

        $response = $this->get('/greeting');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Xin chào']); // Tùy nội dung của VietnameseTranslator
    }

    public function test_greeting_in_english()
    {
        config(['app.locale' => 'en']);

        $response = $this->get('/greeting');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Hello']); // Tùy nội dung của EnglishTranslator
    }
}

