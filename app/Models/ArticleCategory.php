<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = [
        'name','user_id'
    ];//end of fillable

    protected $hidden = [
        'user_id'
    ];//end of hidden

    protected $appends = [

    ];//end of appends

    public function user(){
        return $this->belongsTo(User::class);
    }//end of user relation

    public function articles(){
        return $this->hasMany(Article::class,'cat_id');
    }//end of articles relation
}
