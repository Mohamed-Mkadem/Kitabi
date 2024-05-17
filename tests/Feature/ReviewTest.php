<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\State;
use App\Models\Admin\Book;
use App\Models\BookOrder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $user;
    private Order $order;
    private Book $unOrderedBook;
    private Book $orderedBook;

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

        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'status' => 'delivered'
        ]);

        $this->unOrderedBook = Book::factory()->create();
        $this->orderedBook = Book::factory()->create();
        BookOrder::create([
            'book_id' => $this->orderedBook->id,
            'order_id' => $this->order->id,
            'price' => $this->orderedBook->price,
            'image' => $this->orderedBook->image,
            'quantity' => 2,
            'sub_total' => $this->orderedBook->price * 2
        ]);
    }


    public function test_user_can_review_a_book()
    {
        $this->actingAs($this->user)->post(route('client.reviews.store', ['book' => $this->orderedBook->id]), ['stars' => 5, 'comment' => 'Great Book'])->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'book_id' => $this->orderedBook->id,
            'user_id' => $this->user->id,
            'stars' => 5,
            'comment' => 'Great Book'
        ]);
    }
    public function test_user_can_review_review_only_a_bought_and_non_reviewed_book()
    {
        $this->actingAs($this->user)->post(route('client.reviews.store', ['book' => $this->unOrderedBook]), ['stars' => 5, 'comment' => 'Great Book'])->assertForbidden();
        $this->assertDatabaseMissing('reviews', [
            'book_id' => $this->unOrderedBook->id,
            'user_id' => $this->user->id,
            'stars' => 5,
            'comment' => 'Great Book'
        ]);
    }
}
