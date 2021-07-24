<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Article;
use App\Models\Workout;
use App\Models\PlanCategory;
use App\Models\ArticleCategory;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'image'
    ];//end of fillable


    protected $hidden = [
        'password', 'remember_token',
    ];//end of hidden


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];//end of casts

    protected $appends = [
        'image_path',
    ];//end of appends

    public function getImagePathAttribute(){
        return asset('images/users/'.$this->image);
    }//to return image path

    public function getNameAttribute($val){
        return ucfirst($val);
    }//to uppercase the first letter

    public function articleCategories(){
        return $this->hasMany(ArticleCategory::class);
    }//end of articleCategories relation

    public function articles(){
        return $this->hasMany(Article::class);
    }//end of articles relation

    public function plans(){
        return $this->hasMany(Plan::class);
    }//end of plans relation

    public function planCategories(){
        return $this->hasMany(PlanCategory::class);
    }//end of planCategories relation

    public function workouts(){
        return $this->hasMany(Workout::class);
    }//end of workouts relation
}
