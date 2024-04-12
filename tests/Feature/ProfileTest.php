<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = $this->getUser();

        $response = $this
            ->actingAs($user)
            ->get('/account');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = $this->getUser();

        $state = $this->getState();
        $cityId = $this->getCityId($state);
        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'first_name' => 'First',
                'last_name' => 'Last',
                'state_id' => $state->id,
                'city_id' => $cityId,
                'phone' => '20101202',
                'address' => '18, Awesome Street Name',
                'email' => 'test@example.com',

            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account/edit');

        $user->refresh();

        $this->assertSame('First', $user->first_name);
        $this->assertSame('Last', $user->last_name);
        $this->assertSame('20101202', $user->phone);
        $this->assertSame('18, Awesome Street Name', $user->address);
        $this->assertSame($state->id, $user->state_id);
        $this->assertSame($cityId, $user->city_id);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = $this->getUser();
        $state = $this->getState();
        $cityId = $this->getCityId($state);
        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'email' => $user->email,
                'state_id' => $state->id,
                'city_id' => $cityId,
                'phone' => '20101202',
                'address' => '18, Awesome Street Name',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account/edit');

        $this->assertNotNull($user->refresh()->email_verified_at);
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
    private function getUser(): User
    {

        $state = $this->getState();
        $user = User::factory()->create([
            'state_id' => $state->id,
            'city_id' => $this->getCityId($state),

        ]);
        return $user;
    }
}
