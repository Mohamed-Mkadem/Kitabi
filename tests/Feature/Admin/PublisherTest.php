<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Publisher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublisherTest extends TestCase
{

    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $admin;
    private User $user;
    private Publisher $publisher;

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
        $this->publisher = Publisher::factory()->create([
            'name' => 'Publisher'
        ]);
    }

    public function test_publishers_page_can_be_rendered_successfully(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/dashboard/publishers');

        $response->assertStatus(200);
    }
    public function test_regular_user_cannot_access_publishers_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/dashboard/publishers');

        $response->assertStatus(403);
    }

    public function test_publishers_can_be_created()
    {
        $data = ['name' => 'publisher Name'];

        $response = $this->actingAs($this->admin)->post('/dashboard/publishers', $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('publishers', $data);
    }
    public function test_publishers_can_be_updated()
    {
        $data = ['name' => 'New Name'];

        $response = $this->actingAs($this->admin)->put('/dashboard/publishers/' . $this->publisher->id, $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');
        $this->publisher->refresh();
        $this->assertDatabaseHas('publishers', $data);
        $this->assertSame($data['name'], $this->publisher->name);
    }
    public function test_publishers_can_be_deleted()
    {
        $response = $this->actingAs($this->admin)->delete('/dashboard/publishers/' . $this->publisher->id);

        $response->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertModelMissing($this->publisher);
    }
}
