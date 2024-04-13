<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = $this->getUser();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $user = $this->getUser();

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = $this->getUser();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
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
            'email_verified_at' => null,
        ]);
        return $user;
    }
}
