<?php

use App\Models\Workout;
use Illuminate\Database\Seeder;

class WorkoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workout::create([
            'name'=>'rest day',
            'muscle'=>'all',
            'image'=>'rest.jpg',
            'equipment_type'=>'bed',
            'level'=>'baby',
            'exercise_type'=> 'amazing',
            'user_id'=>1,
        ]);
    }
}
