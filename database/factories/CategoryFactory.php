<?php

namespace Database\Factories;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brandName = $this->faker->words($this->faker->numberBetween(3, 8), true);
        $slug = strtolower($brandName);

        return [
            'name' => $brandName,
            'slug' => $slug,
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }

}
