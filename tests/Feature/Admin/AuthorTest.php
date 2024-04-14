<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Admin\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{


    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $admin;
    private User $user;
    private Author $author;

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
        $this->author = Author::factory()->create([
            'name' => 'Author'
        ]);
    }

    public function test_authors_page_can_be_rendered_successfully(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/dashboard/authors');

        $response->assertStatus(200);
    }
    public function test_regular_user_cannot_access_authors_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/dashboard/authors');

        $response->assertStatus(403);
    }

    public function test_authors_can_be_created()
    {
        $data = ['name' => 'Author Name'];

        $response = $this->actingAs($this->admin)->post('/dashboard/authors', $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('authors', $data);
    }
    public function test_authors_can_be_updated()
    {
        $data = ['name' => 'New Name'];

        $response = $this->actingAs($this->admin)->put('/dashboard/authors/' . $this->author->id, $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');
        $this->author->refresh();
        $this->assertDatabaseHas('authors', $data);
        $this->assertSame($data['name'], $this->author->name);
    }
    public function test_authors_can_be_deleted()
    {
        $response = $this->actingAs($this->admin)->delete('/dashboard/authors/' . $this->author->id);

        $response->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertModelMissing($this->author);
    }
}
