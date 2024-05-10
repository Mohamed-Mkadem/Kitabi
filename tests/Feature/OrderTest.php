<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\State;
use App\Models\Admin\Book;
use Database\Factories\Admin\BookFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{

    use RefreshDatabase;
    private State $state;
    private City $city;
    private User $orderOwner;
    private User $nonOrderOwner;
    private Order $order;
    private Book $book;

    public function setup(): void
    {
        parent::setup();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);
        $this->orderOwner = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);
        $this->nonOrderOwner = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'status' => 'banned'
        ]);

        $this->order = Order::factory()->create([
            'user_id' => $this->orderOwner->id,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);

        $this->book = Book::factory()->create();
    }

    public function test_order_page_can_be_rendered_successfully()
    {
        $response = $this->actingAs($this->orderOwner)->get('orders/' . $this->order->id);

        $response->assertOk();
    }

    public function test_orders_page_can_be_rendered_successfully()
    {
        $response = $this->actingAs($this->orderOwner)->get('orders/');

        $response->assertOk();
    }

    public function test_only_order_owner_can_show_order_page()
    {
        $response = $this->actingAs($this->nonOrderOwner)->get('orders/' . $this->order->id);

        $response->assertForbidden();
    }

    public function test_active_user_can_place_an_order()
    {
        $data = $this->getData();

        $response = $this->actingAs($this->orderOwner)->post('orders/', $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors();
    }
    public function test_banned_user_cannot_place_an_order()
    {
        $data = $this->getdata();

        $response = $this->actingAs($this->nonOrderOwner)->post('orders/', $data);

        $response->assertForbidden();
    }

    private function buildCart()
    {
        $cart = [
            [
                'productId' => $this->book->id,
                'quantity' => 1,
                'imageUrl' => 'https://picsum.photos/200/300',
                'price' => 10000
            ]
        ];
        return json_encode($cart);
    }
    private function getData()
    {
        return [
            'first_name' => $this->orderOwner->first_name,
            'last_name' => $this->orderOwner->last_name,
            'phone' => $this->orderOwner->phone,
            'address' => $this->orderOwner->address,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'shipping_cost' => 7000,
            'cart' => $this->buildCart()
        ];
    }
}
