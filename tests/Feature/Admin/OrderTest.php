<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\State;
use App\Models\Admin\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private State $state;
    private City $city;
    private User $user;
    private User $admin;
    private Order $order;
    private Book $book;

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
        ]);

        $this->book = Book::factory()->create();
    }

    public function test_orders_page_can_be_rendered_successfully()
    {
        $response = $this->actingAs($this->admin)->get('dashboard/orders');

        $response->assertOk();
    }
    public function test_order_page_can_be_rendered_successfully()
    {
        $response = $this->actingAs($this->admin)->get('dashboard/orders/' . $this->order->id);

        $response->assertOk();
    }

    public function test_user_cannot_access_order_page()
    {
        $response = $this->actingAs($this->user)->get('dashboard/orders/' . $this->order->id);

        $response->assertForbidden();
    }
    public function test_user_cannot_access_orders_page()
    {
        $response = $this->actingAs($this->user)->get('dashboard/orders/');

        $response->assertForbidden();
    }

    public function test_admin_can_cancel_an_order()
    {
        $this->actingAs($this->admin);
        $response = $this->patch(route('admin.orders.cancel', ['order' => $this->order->id]));

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'cancelled',
        ]);
        $response->assertRedirect()->assertSessionHas('success');
    }


    public function test_admin_can_confirm_an_order()
    {
        $this->actingAs($this->admin);

        $response = $this->patch(route('admin.orders.confirm', ['order' => $this->order->id]));

        $response->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'confirmed',
        ]);
    }


    public function test_admin_can_ship_an_order()
    {
        $this->actingAs($this->admin);

        $this->order->update(['status' => 'confirmed']);

        $response = $this->patch(route('admin.orders.ship', ['order' => $this->order->id]));

        $response->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'shipped',
        ]);
    }

    public function test_admin_can_deliver_an_order()
    {
        $this->actingAs($this->admin);

        $this->order->update(['status' => 'shipped']);

        $response = $this->patch(route('admin.orders.deliver', ['order' => $this->order->id]));

        $response->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'delivered',
        ]);
    }

    public function test_admin_can_return_an_order()
    {
        $this->actingAs($this->admin);

        $this->order->update(['status' => 'shipped']);

        $response = $this->patch(route('admin.orders.return', ['order' => $this->order->id]));

        $response->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'returned',
        ]);
    }
}
