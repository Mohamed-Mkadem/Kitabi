<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $user = $this->getUser();

        $response = $this
            ->actingAs($user)
            ->from('/account')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = $this->getUser();

        $response = $this
            ->actingAs($user)
            ->from('/account')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('current_password')
            ->assertRedirect('/account');
    }

    private function getState()
    {
        $state = State::factory()->create();
        return $state;
    }
    private function getCityId($state)
    {

        $city = City::factory()->create([
            'state_id' => $state->id
        ]);
        return $city->id;
    }
    private function getUser()
    {

        $state = $this->getState();
        $user = User::factory()->create([
            'state_id' => $state->id,
            'city_id' => $this->getCityId($state),

        ]);
        return $user;
    }
}
