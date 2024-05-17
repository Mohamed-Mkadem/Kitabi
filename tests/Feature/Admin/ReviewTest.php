<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\State;
use App\Models\BookOrder;
use App\Models\Admin\Book;
use App\Models\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $user;
    private Order $order;
    private Review $review;
    private Book $book;
    private User $admin;
    public function setup(): void
    {
        parent::setup();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);
        $this->user = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);
        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'status' => 'delivered'
        ]);
        $this->book = Book::factory()->create();
        $this->review = Review::create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'stars' => 5,
            'comment' => null
        ]);
    }

    public function test_admin_can_access_reviews_page()
    {
        $this->actingAs($this->admin)->get(route('admin.reviews.index'))->assertOk();
    }
    public function test_admin_can_delete_a_review()
    {
        $this->actingAs($this->admin)->delete(route('admin.reviews.destroy', ['review' => $this->review]))->assertSessionHas('success');

        $this->assertDatabaseMissing('reviews', [
            'id' => $this->review->id
        ]);
    }
    public function test_user_cannot_access_reviews_page()
    {
        $this->actingAs($this->user)->get(route('admin.reviews.index'))->assertForbidden();
    }
    public function test_user_cannot_delete_a_review()
    {
        $this->actingAs($this->user)->delete(route('admin.reviews.destroy', ['review' => $this->review]))->assertForbidden();

        $this->assertDatabaseHas('reviews', [
            'id' => $this->review->id
        ]);
    }
}
