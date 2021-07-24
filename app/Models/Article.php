<?php

namespace App\Models;

use App\Models\User;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'content','image','video','copied_from','user_id','cat_id'
    ];//end of fillable

    protected $appends = [
        'image_path','video_path'
    ];//end of appends

    protected $hidden = [
        'user_id', 'cat_id'
    ];//end of hidden

    public function getImagePathAttribute(){
        return asset('images/articles/'.$this->image);
    }//end of image path attr

    public function getVideoPathAttribute(){
        return asset('videos/articles/'.$this->video);
    }//end of video path attr

    public function user()
    {
        return $this->belongsTo(User::class);
    }//end of user relationship

    public function articleCategory(){
        return $this->belongsTo(ArticleCategory::class,'cat_id');
    }//end of articleCategory relation
}
