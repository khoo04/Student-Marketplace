<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(5),
            'quantity_available' => $this->faker->randomFloat(2,10),
            'price' => $this->faker->randomFloat(2,10,500),
            'rating' => $this->faker->randomFloat(1,0,5),
            'condition' => $this->faker->randomElement(['new','used']),
            'approve_status' => 'pending',
            'category_id' => $this->faker->randomElement($categoryIds),
            'user_id' => 3,
        ];
    }
}
