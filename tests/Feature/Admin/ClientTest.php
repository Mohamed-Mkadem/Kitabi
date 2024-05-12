<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $admin;
    private User $client;
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
        $this->client = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'user'
        ]);
    }


    public function test_admin_can_view_clients_index_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.clients.index'))
            ->assertStatus(200);
    }


    public function test_admin_can_view_client_details_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.clients.show', $this->client))
            ->assertStatus(200);
    }


    public function test_admin_can_ban_client()
    {
        $this->actingAs($this->admin)
            ->patch(route('admin.clients.ban', $this->client))
            ->assertRedirect();

        $this->assertTrue($this->client->fresh()->isBanned());
    }
    public function test_admin_can_activate_client()
    {

        $this->client->update(['status' => 'banned']);

        $this->actingAs($this->admin)
            ->patch(route('admin.clients.activate', $this->client))
            ->assertRedirect();

        $this->assertTrue($this->client->fresh()->isActive());
    }
}
