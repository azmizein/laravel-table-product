<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 999),
            'stock' => $this->faker->numberBetween(0, 500),
            'description' => $this->faker->paragraph(),
        ];
    }
}
