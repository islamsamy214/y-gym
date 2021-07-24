<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'name','muscle','image','ytb_link','equipment_type','level', 'exercise_type','user_id'
    ];//end of fillable

    protected $appends = [
        'image_path'
    ];//end of appends

    protected $hidden = [
        'user_id'
    ];//end of hidden

    public function getImagePathAttribute(){
        return asset('images/workouts/'.$this->image);
    }//end of image path

    public function user()
    {
        return $this->belongsTo(User::class);
    }//end of user relationship

    public function plans(){
        return $this->belongsToMany(Plan::class,'plan_workout')->withPivot('week','order','reps','repeats','day');
    }//end of plans relation
}
