<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'item_name' => $this->faker->word(),
            'item_brand' => $this->faker->company(),
            'item_amount' => $this->faker->numberBetween(500, 10000),
            'item_description' => $this->faker->sentence(),
            'item_state' => '良好',
            'image_url' => 'items/test_image.png',
        ];
    }
}
