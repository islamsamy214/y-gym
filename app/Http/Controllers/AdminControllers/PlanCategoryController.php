<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\PlanCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanCategoryRequest;

class PlanCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:plan_categories_read'])->only('index');
        $this->middleware(['permission:plan_categories_create'])->only('store');
        $this->middleware(['permission:plan_categories_update'])->only('update');
        $this->middleware(['permission:plan_categories_delete'])->only('destroy');
    }//end of construct

    public function index(Request $request)
    {
        if($request->search){
            $plan_categories = PlanCategory::where('name','like','%'.$request->search.'%')->latest()->paginate(10);
        }else{
            $plan_categories = PlanCategory::latest()->paginate(10);
        }

        return view('admin.plan-categories.index',compact('plan_categories','request'));
    }//end of index


    public function store(PlanCategoryRequest $request)
    {
        $request->validated();

        $request_data = [
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ];
        PlanCategory::create($request_data);

        session()->flash('success',__('site.plan_category_added'));
        return response()->json([
            'status' => true,
        ]);
    }//end of store


    public function edit(PlanCategory $plan_category)
    {

        return view('admin.plan-categories.edit',compact('plan_category'));

    }//end of edit


    public function update(PlanCategoryRequest $request, PlanCategory $plan_category)
    {

        $request->validated();

        $request_data = [
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ];
        $plan_category->update($request_data);

        session()->flash('success',__('site.plan_category_updated'));
        return redirect()->route('plan_categories.index');
    }//end of update


    public function destroy(PlanCategory $plan_category)
    {
        $plan_cont = new PlanController();
        $plans = $plan_category->plans;
        foreach($plans as $plan){
            $plan_cont->destroy($plan);
        }//end of deleting the relations

        $plan_category->delete();
        session()->flash('success',__('site.plan_category_deleted'));
        return redirect()->route('plan_categories.index');
    }//end of destroy
}
