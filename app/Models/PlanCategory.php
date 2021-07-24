<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PlanCategory extends Model
{
    protected $fillable = [
        'name','user_id'
    ];//end of fillable

    protected $hidden = [
        'user_id'
    ];//end of hidden

    protected $appends = [

    ];//end of appends

    public function getNameAttribute($name){
        return ucfirst($name);
    }//end of uppercase

    public function user(){
        return $this->belongsTo(User::class);
    }//end of user relation

    public function plans(){
        return $this->hasMany(Plan::class,'cat_id');
    }//end of plans relation
}
