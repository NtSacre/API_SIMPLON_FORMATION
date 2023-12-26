<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'admin',
            'description' => 'peut faire le crud pour une formation',
        ];
    }

    public function candidat() : RoleFactory
    {
     return $this->state([
        'name' => 'candidat',
            'description' => 'peut postuler à une formation',
    
     ]);
    }
}
