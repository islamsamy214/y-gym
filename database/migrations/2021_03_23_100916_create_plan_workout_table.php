<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_workout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Biginteger('plan_id')->unsigned();
            $table->Biginteger('workout_id')->unsigned();
            $table->smallInteger('order');
            $table->smallInteger('reps');
            $table->smallInteger('repeats');
            $table->smallInteger('day');
            $table->smallInteger('week');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_workout');
    }
}
