<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => fake()->sentence, #using the faker method to generate a sentence
            'description' => fake()->paragraph, #using a faker method to generate a paragraph
            'long_description' => fake()->paragraph(7,true), #using a faker function to generate a 7 sentences paragraph
            'completed' => fake()->boolean(), #using a faker function to generate a boolean value
 
        ];
    }
}
