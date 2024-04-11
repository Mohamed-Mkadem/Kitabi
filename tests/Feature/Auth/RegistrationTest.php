<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\City;
use App\Models\State;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $state = State::factory()->create();
        $city = City::factory()->create([
            'state_id' => $state->id
        ]);
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $state = State::factory()->create();
        $city = City::factory()->create([
            'state_id' => $state->id
        ]);
        $response = $this->post('/register', [

            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'state' => $state->id,
            'city' => $city->id,
            'phone' => '20101202',
            'address' => '18, Awesome Street Name',
            'email' => fake()->unique()->safeEmail(),
            'password_confirmation' => 'password',
            'password' => 'password',


        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
