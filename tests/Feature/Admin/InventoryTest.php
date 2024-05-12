<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Admin\Book;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;
    private Book $book;
    private City $city;
    private State $state;

    public function setup(): void
    {
        parent::setUp();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);
        $this->book = Book::factory()->create([
            'quantity' => 100
        ]);
        $this->admin = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'admin'
        ]);
        $this->user = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);
    }

    public function test_admin_can_view_inventory_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.inventory.index'))
            ->assertStatus(200);
    }

    public function test_user_cannot_view_inventory_page()
    {
        $this->actingAs($this->user)
            ->get(route('admin.inventory.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_increment_book_quantity()
    {
        $this->actingAs($this->admin)
            ->patch(route('admin.inventory.manage', ['book' => $this->book->id]), [
                'quantity' => 10,
                'operation' => 'increment',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => $this->book->quantity + 10,
        ]);
    }
    public function test_admin_can_decrement_book_quantity()
    {
        $this->actingAs($this->admin)
            ->patch(route('admin.inventory.manage', ['book' => $this->book->id]), [
                'quantity' => 10,
                'operation' => 'decrement',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => $this->book->quantity - 10,
        ]);
    }
    public function test_user_cannot_increment_book_quantity()
    {
        $this->actingAs($this->user)
            ->patch(route('admin.inventory.manage', ['book' => $this->book->id]), [
                'quantity' => 10,
                'operation' => 'increment',
            ])
            ->assertForbidden();
    }
    public function test_user_cannot_decrement_book_quantity()
    {
        $this->actingAs($this->user)
            ->patch(route('admin.inventory.manage', ['book' => $this->book->id]), [
                'quantity' => 10,
                'operation' => 'decrement',
            ])
            ->assertForbidden();
    }
}
