<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Plan;
use App\Models\Workout;
use App\Models\PlanCategory;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:plans_read'])->only('index');
        $this->middleware(['permission:plans_create'])->only('store');
        $this->middleware(['permission:plans_update'])->only('update');
        $this->middleware(['permission:plans_delete'])->only('destroy');
    }//end of construct


    public function index(Request $request)
    {
        if($request->search){
            $plans = Plan::where('name','like','%'.$request->search.'%')
                            ->orWhereHas('planCategory',function($q)use($request){
                                $q->where('name','like','%'.$request->search.'%');
                            })->latest()->paginate(3);
        }else{
            $plans = Plan::latest()->paginate(3);
        }

        $plan_categories = PlanCategory::get();

        return view('admin.plans.index',compact('plans','request','plan_categories'));
    }//end of index


    public function store(PlanRequest $request)
    {
        $request->validated();

        $request_data = $request->except('image');
        $request_data['user_id'] = auth()->user()->id;

        if($request->image){
            $img = Image::make($request->image);
            $img->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img_name = rand().'.'.$request->image->getClientOriginalExtension();

            $img->save(public_path('images/plans/'.$img_name),60);

            $request_data['image'] = $img_name;
        }

        Plan::create($request_data);
        session()->flash('success',__('site.plan_created'));
        return response()->json([
            'status' => true,
        ]);
    }//end of store


    public function show(Plan $plan)
    {
        $workouts = Workout::get();
        return view('admin.plans.set-plan',compact('plan','workouts'));

    }//end of show


    public function setPlan(Request $request, $plan_id){
        $request->validate([
            'workout_ids'=>'required|array',
            'repeats'=>'required|array',
            'repeats.*'=>'numeric',
            'reps'=>'required|array',
            'reps.*'=>'numeric',
            'week'=>'required|numeric',
            'day'=>'required|numeric',
        ]);

        $plan = Plan::findOrFail($plan_id);

        foreach($request->workout_ids as $index => $workout_id){
            Workout::findOrFail($workout_id);
            $plan->workouts()->attach($workout_id,[
                'week'=>$request->week,
                'day'=>$request->day,
                'order'=>$index,
                'repeats'=>$request->repeats[$index],
                'reps'=>$request->reps[$index],
            ]);
        }
        session()->flash('success',__('site.training_created'));

        if($request->week == $plan->duration && $request->day == 7){
            return response()->json([
                'status' => true,
            ]);
        }else{
            if($request->day == 7){
                return response()->json([
                    'week'=>true,
                    'current_week'=>$request->week,
                    'next_week'=>$request->week+1,
                ]);
            }else{

                return response()->json([
                    'day'=>true,
                    'next_day'=>$request->day+1,
                ]);
            }
        }

    }//end of setPlan


    public function editPlan($plan_id){
        $workouts = Workout::get();
        $plan = Plan::findOrFail($plan_id);
        return view('admin.plans.edit-plan',compact('plan','workouts'));

    }//end of editPlan


    public function updatePlan(Request $request,$plan_id){
        $request->validate([
            'workout_ids'=>'array|required',
            'repeats'=>'array|required',
            'repeats.*'=>'numeric',
            'reps'=>'array|required',
            'reps.*'=>'numeric',
            'week'=>'required|numeric',
            'day'=>'required|numeric',
        ]);

        $plan = Plan::findOrFail($plan_id);

        DB::delete('DELETE FROM `plan_workout` WHERE day = ? AND week = ?', [$request->day, $request->week]);

        foreach($request->workout_ids as $index => $workout_id){
            Workout::findOrFail($workout_id);

            $plan->workouts()->attach($workout_id,[
                'week'=>$request->week,
                'day'=>$request->day,
                'order'=>$index,
                'repeats'=>$request->repeats[$index],
                'reps'=>$request->reps[$index],
            ]);
        }
        session()->flash('success',__('site.training_updated'));

        return response()->json([
            'status' => true,
        ]);

    }//end of updatePlan

    public function edit(Plan $plan)
    {
        $plan_categories = PlanCategory::get();
        return view('admin.plans.edit',compact('plan','plan_categories'));
    }//end of edit


    public function update(PlanRequest $request, Plan $plan)
    {
        $request->validated();
        $request_data = $request->except('image');

        if($request->image){
            if($plan->image){
                Storage::disk('public_image')->delete('plans/'.$plan->image);
            }

            $img = Image::make($request->image);
            $img->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img_name = rand().'.'.$request->image->getClientOriginalExtension();

            $img->save(public_path('images/plans/'.$img_name),60);

            $request_data['image'] = $img_name;
        }

        $plan->update($request_data);
        session()->flash('success',__('site.plan_updated'));
        return redirect()->route('plans.index');
    }//end of update


    public function destroy(Plan $plan)
    {
        $plan->workouts()->detach();

        if($plan->image){
            Storage::disk('public_image')->delete('plans/'.$plan->image);
        }
        $plan->delete();
        session()->flash('success',__('site.plan_deleted'));
        return redirect()->route('plans.index');
    }//end of destroy
}
