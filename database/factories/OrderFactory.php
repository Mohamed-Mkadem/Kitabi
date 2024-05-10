<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::Factory(),
            'status' => 'pending',
            'amount' => rand(1000, 100000),
            'no_of_items' => rand(5, 10),
            'note' => fake()->paragraph(),
            'state_id' => 1,
            'city_id' => 1,
            'customer_name' => fake()->firstName(),
            'shipping_cost' => 7000,
            'shipping_address' => fake()->address(),
            'customer_phone' => '20254102',
        ];
    }

    public function cancelled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
            ];
        });
    }
    public function confirmed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'confirmed',
            ];
        });
    }
    public function shipped(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'shipped',
            ];
        });
    }
    public function delivered(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'delivered',
            ];
        });
    }
    public function returned(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
            ];
        });
    }
}
