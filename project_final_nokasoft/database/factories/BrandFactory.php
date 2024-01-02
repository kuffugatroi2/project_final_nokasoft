<?php

namespace Database\Factories;

use App\Models\Admin;
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
        $brands = ['Vertu', 'Rolex', 'Omega', 'Tag Heuer', 'Patek Philippe', 'Apple', 'Samsung', 'Huawei'];
        $adminIds = Admin::pluck('id')->toArray();

        return [
            'name' => $this->faker->randomElement($brands),
            'status' => $this->faker->randomElement($status),
            'created_by' => $this->faker->randomElement($adminIds),
            'updated_by' => $this->faker->randomElement($adminIds),
        ];
    }
}
