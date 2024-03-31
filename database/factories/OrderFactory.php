<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class OrderFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;


    public function definition(): array
    {

            return [
            'customer_name' => $this->faker->sentence(2),
            'total_price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(10, 100),
            'product_id' => function () {
                return Product::factory()->create()->id;
            },
        ];
    }
}
