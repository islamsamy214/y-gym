<?php

namespace App\Http\Controllers\WebControllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            $articles = Article::where('title','like','%'.$request->search.'%')
                            ->orWhereHas('articleCategory',function($q)use($request){
                                $q->where('name','like','%'.$request->search.'%');
                            })->latest()->paginate(9);
        }else{
            $articles = Article::latest()->paginate(9);
        }
        $article_categories = ArticleCategory::get();
        return view('web.articles.index',compact('articles','request','article_categories'));
    }//end of index
}
