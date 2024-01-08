<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
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
        $adminIds = Admin::pluck('id')->toArray();
        $brandIds = Brand::pluck('id')->toArray();
        $categories = [
            'Vertu Signature S', 'Vertu Aster', 'Vertu Meta', 'Vertu Ti', 'Vertu Touch',
            'Vertu Extraordinavy V', 'Day Date', 'Datejust'
        ];
        $status = ['active', 'unactive'];
        $type = ['mobile', 'watch'];
        $nowInVietnam = Carbon::now('Asia/Ho_Chi_Minh');

        return [
            'brand_id' => $this->faker->randomElement($brandIds),
            'name' => $this->faker->randomElement($categories),
            'status' => $this->faker->randomElement($status),
            'type' => $this->faker->randomElement($type),
            'created_by' => $this->faker->randomElement($adminIds),
            'updated_by' => $this->faker->randomElement($adminIds),
            'created_at' => $nowInVietnam,
            'updated_at' => $nowInVietnam,
        ];
    }
}
