<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:articles_read'])->only('index');
        $this->middleware(['permission:articles_create'])->only('store');
        $this->middleware(['permission:articles_update'])->only('update');
        $this->middleware(['permission:articles_delete'])->only('destroy');
    }//end of contruct


    public function index(Request $request)
    {
        if($request->search){
            $articles = Article::where('title','like','%'.$request->search.'%')
                                    ->orWhereHas('articleCategory',function($q)use($request){
                                        $q->where('name','like','%'.$request->search.'%');
                                    })->latest()->paginate(6);
        }else{
            $articles = Article::latest()->paginate(6);
        }

        $article_categories = ArticleCategory::get();

        return view('admin.articles.index',compact('articles','request','article_categories'));
    }//end of index


    public function store(ArticleRequest $request)
    {
        $request->validated();

        $request_data = $request->except(['image','video']);
        $request_data['user_id'] = auth()->user()->id;

        if($request->image){
            $img = Image::make($request->image);
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save(public_path('images/articles/'.$request->image->hashName()),60);

            $request_data['image'] = $request->image->hashName();
        }//end of image save

        if($request->video){

            $vid = $request->video;
            $vid_name = rand().'.'.$vid->getClientOriginalExtension();
            $vid->move(public_path('videos/articles'),$vid_name);

            $request_data['video'] = $vid_name;
        }//end of video move

        Article::create($request_data);
        session()->flash('success', __('site.article_created'));
        return response()->json([
            'status' => true,
        ]);

    }//end of store


    public function edit(Article $article)
    {
        $article_categories = ArticleCategory::get();

        return view('admin.articles.edit',compact('article','article_categories'));
    }//end of edit


    public function update(ArticleRequest $request, Article $article)
    {
        $request->validated();

        $request_data = $request->except(['image','video']);

        if($request->image){
            if($article->image){
                Storage::disk('public_image')->delete('articles/'.$article->image);
            }
            $img = Image::make($request->image);
            $img->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save(public_path('images/articles/'.$request->image->hashName()),60);

            $request_data['image'] = $request->image->hashName();
        }

        if($request->video){
            if($article->video){
                Storage::disk('public_video')->delete('articles/'.$article->video);
            }
            $vid = $request->video;
            $vid_name = rand().'.'.$vid->getClientOriginalExtension();
            $vid->move(public_path('videos/articles'),$vid_name);

            $request_data['video'] = $vid_name;
        }

        $article->update($request_data);
        session()->flash('success', __('site.article_updated'));
        return redirect()->route('articles.index');
    }//end of update


    public function destroy(Article $article)
    {
        if($article->image){
            Storage::disk('public_image')->delete('articles/'.$article->image);
        }
        if($article->video){
            Storage::disk('public_video')->delete('articles/'.$article->video);
        }

        $article->delete();
        session()->flash('success', __('site.article_deleted'));
        return redirect()->route('articles.index');
    }//end of destroy
}
