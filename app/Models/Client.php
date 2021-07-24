<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'phone','plan_id','day','week', 'payed_date', 'expiry_date'
    ];//end of fillable

    protected $hidden = [
        'password', 'remember_token',
    ];//end of hidden

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];//end of casts

    protected $appends = [
        'image_path','is_subscribed'
    ];//end of appends

    public function getIsSubscribedAttribute(){
        $isExpired = strtotime($this->expiry_date) >= time();
        return $isExpired;
    }//end of returning if the client expired or not

    public function getImagePathAttribute(){
        return asset('images/clients/'.$this->image);
    }//end of imagepath attribute

    public function plan(){
        return $this->belongsTo(Plan::class);
    }//end of plan relation
}
