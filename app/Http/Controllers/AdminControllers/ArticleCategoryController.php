<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:article_categories_read'])->only('index');
        $this->middleware(['permission:article_categories_create'])->only('store');
        $this->middleware(['permission:article_categories_update'])->only('update');
        $this->middleware(['permission:article_categories_delete'])->only('destroy');
    }//end of constract


    public function index(Request $request)
    {
        if($request->search){
            $article_categories = ArticleCategory::where('name','like','%'.$request->search.'%')->latest()->paginate(10);
        }else{
            $article_categories = ArticleCategory::latest()->paginate(10);
        }

        return view('admin.article-categories.index',compact('article_categories','request'));
    }//end of index


    public function store(ArticleCategoryRequest $request)
    {

        $request->validated();

        $request_data = [
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ];
        ArticleCategory::create($request_data);
        session()->flash('success',__('site.article_category_created'));
        return response()->json([
            'status'=>true,
        ]);

    }//end of store


    public function edit(ArticleCategory $article_category)
    {
        return view('admin.article-categories.edit',compact('article_category'));
    }//end of edit


    public function update(ArticleCategoryRequest $request, ArticleCategory $article_category)
    {

        $request->validated();

        $request_data = [
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ];
        $article_category->update($request_data);
        session()->flash('success',__('site.article_category_updated'));
        return redirect()->route('article_categories.index');
    }//end of update

    public function destroy(ArticleCategory $article_category)
    {
        $art_cont = new ArticleController();
        $articles = $article_category->articles;
        foreach($articles as $article){
            $art_cont->destroy($article);
        }//end of deleting relations

        $article_category->delete();
        session()->flash('success',__('site.article_category_deleted'));
        return redirect()->route('article_categories.index');
    }//end of destroy
}
