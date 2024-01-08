<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['active', 'unactive'];
        $brands = ['Vertu', 'Apple', 'Rolex', 'Hublot', 'Franck Muller', 'Chopard', 'Audemars Piguet', 'Patel Philippe'];
        $adminIds = Admin::pluck('id')->toArray();

        return [
            'name' => $this->faker->randomElement($brands),
            'status' => $this->faker->randomElement($status),
            'created_by' => $this->faker->randomElement($adminIds),
            'updated_by' => $this->faker->randomElement($adminIds),
            'created_at' => $this->faker->date("Y-m-d H:i:s"),
            'updated_at' => $this->faker->date("Y-m-d H:i:s"),
        ];
    }
}
