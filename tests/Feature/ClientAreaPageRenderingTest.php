<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientAreaPageRenderingTest extends TestCase
{

    public function test_home_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_about_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
    public function test_contact_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
    public function test_terms_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
    }
    public function test_privacy_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
    }
    public function test_faqs_page_can_be_rendered_successfully(): void
    {
        $response = $this->get('/faqs');

        $response->assertStatus(200);
    }
}
