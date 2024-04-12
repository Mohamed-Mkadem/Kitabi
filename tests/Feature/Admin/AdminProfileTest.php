<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    private State $state;
    private City $city;
    private User $admin;
    private User $user;
    public function setup(): void
    {
        parent::setup();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);

        $this->admin = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'admin'
        ]);
        $this->user = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'user'
        ]);
    }

    public function test_admin_profile_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/dashboard/account');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {

        $response = $this
            ->actingAs($this->admin)
            ->patch('/dashboard/profile', [
                'first_name' => 'First',
                'last_name' => 'Last',
                'state_id' => $this->state->id,
                'city_id' => $this->city->id,
                'phone' => '20101202',
                'address' => '18, Awesome Street Name',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/dashboard/account/edit');

        $this->admin->refresh();

        $this->assertSame('First', $this->admin->first_name);
        $this->assertSame('Last', $this->admin->last_name);
        $this->assertSame('20101202', $this->admin->phone);
        $this->assertSame('18, Awesome Street Name', $this->admin->address);
        $this->assertSame($this->state->id, $this->admin->state_id);
        $this->assertSame($this->city->id, $this->admin->city_id);
        $this->assertSame('test@example.com', $this->admin->email);
        $this->assertNull($this->admin->email_verified_at);
    }
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {

        $response = $this
            ->actingAs($this->admin)
            ->patch('/dashboard/profile', [
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'email' => $this->admin->email,
                'state_id' => $this->state->id,
                'city_id' => $this->city->id,
                'phone' => '20101202',
                'address' => '18, Awesome Street Name',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/dashboard/account/edit');

        $this->assertNotNull($this->admin->refresh()->email_verified_at);
    }
}
