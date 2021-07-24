<?php

use App\Models\PlanCategory;
use Illuminate\Database\Seeder;

class PlanCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanCategory::create([
            'name' => 'Test',
            'user_id' => 1,
        ]);
    }
}
