<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Category;
use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    private State $state;
    private City $city;
    private User $admin;
    private User $user;
    private Category $category;

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
        $this->category = Category::factory()->create([
            'name' => 'Category'
        ]);
    }

    public function test_categories_page_can_be_rendered_successfully(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/dashboard/categories');

        $response->assertStatus(200);
    }
    public function test_regular_user_cannot_access_categories_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/dashboard/categories');

        $response->assertStatus(403);
    }

    public function test_ategories_can_be_created()
    {
        $data = ['name' => 'Category Name'];

        $response = $this->actingAs($this->admin)->post('/dashboard/categories', $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('categories', $data);
    }
    public function test_categories_can_be_updated()
    {
        $data = ['name' => 'New Name'];

        $response = $this->actingAs($this->admin)->put('/dashboard/categories/' . $this->category->id, $data);

        $response->assertStatus(302)
            ->assertValid('name')
            ->assertSessionHas('success');
        $this->category->refresh();
        $this->assertDatabaseHas('categories', $data);
        $this->assertSame($data['name'], $this->category->name);
    }
    public function test_categories_can_be_deleted()
    {
        $response = $this->actingAs($this->admin)->delete('/dashboard/categories/' . $this->category->id);

        $response->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertModelMissing($this->category);
    }
}
