<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use App\Models\Workout;
use App\Models\PlanCategory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name','duration','image','equipments','level','user_id','cat_id'
    ];//end of fillable

    protected $appends = [
        'image_path'
    ];//end of appends

    protected $hidden = [
        'user_id', 'cat_id'
    ];//end of hidden

    public function getImagePathAttribute(){
        return asset('images/plans/'.$this->image);
    }//end of image_path

    public function getNameAttribute($name){
        return ucfirst($name);
    }//end of uppercase

    public function user()
    {
        return $this->belongsTo(User::class);
    }//end of user relationship

    public function planCategory(){
        return $this->belongsTo(PlanCategory::class,'cat_id');
    }//end of planCategory relation

    public function workouts(){
        return $this->belongsToMany(Workout::class,'plan_workout')->withPivot('week','order','reps','repeats','day');
    }//end of workouts relation

    public function clients(){
        return $this->hasMany(Client::class);
    }//end of clients relaation
}
