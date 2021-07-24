<?php

namespace App\Http\Controllers\WebControllers;

use App\Models\Plan;
use App\Models\Client;
use App\Models\Workout;
use App\Models\PlanCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            $plans = Plan::where('name','like','%'.$request->search.'%')
                            ->orWhereHas('planCategory',function($q)use($request){
                                $q->where('name','like','%'.$request->search.'%');
                            })->latest()->paginate(9);
        }else{
            $plans = Plan::latest()->paginate(9);
        }
        $plan_categories = PlanCategory::get();
        return view('web.plans.index',compact('plans','request','plan_categories'));
    }//end of index


    public function show($plan_id)
    {
        if(!Auth::guard('clients')->user()->is_subscribed){
            return redirect()->route('web.plans');
        }//unsbscribed redirect

        $plan = Plan::findOrFail($plan_id);
        return view('web.plans.show',compact('plan'));
    }//end of show


    public function showWorkout($plan_id,$week,$day)
    {
        if(!Auth::guard('clients')->user()->is_subscribed){
            return redirect()->route('web.plans');
        }//unsbscribed redirect

        $workout_pivots = DB::table('plan_workout')->where('plan_id', '=', $plan_id)->where('day', '=', $day)->where('week','=',$week)->orderBy('order')->get();
        $workouts = [];

        foreach($workout_pivots as $index => $workout_pivot){
            $workouts[$index] = [
                'workout_atrr' => Workout::findOrFail($workout_pivot->workout_id),
                'reps' => $workout_pivot->reps,
                'repeats' => $workout_pivot->repeats
            ];
        }

        return view('web.plans.show-workout',compact('workouts'));
    }//end of showWorkout


    public function start(Request $request)
    {
        if(!Auth::guard('clients')->user()->is_subscribed){
            return redirect()->route('web.plans');
        }//unsbscribed redirect

        $client_id = Crypt::decrypt($request->client_id);
        $client = Client::findOrFail($client_id);

        $client->update([
            'plan_id'=>$request->plan_id,
        ]);

        return redirect()->route('web.plans.show',$request->plan_id);
    }//end of start


    public function startWorkout($plan_id,$week,$day,$client_id)
    {
        if(!Auth::guard('clients')->user()->is_subscribed){
            return redirect()->route('web.plans');
        }//unsbscribed redirect
        
        $client_id = Crypt::decrypt($client_id);
        $client = Client::findOrFail($client_id);
        $client->update([
            'week'=>$week,
            'day'=>$day,
            'plan_id'=>$plan_id,
        ]);

        $workout_pivots = DB::table('plan_workout')->where('plan_id', '=', $plan_id)->where('day', '=', $day)->where('week','=',$week)->orderBy('order')->get();
        $workouts = [];

        foreach($workout_pivots as $index => $workout_pivot){
            $workouts[$index] = [
                'workout_attr' => Workout::findOrFail($workout_pivot->workout_id),
                'reps' => $workout_pivot->reps,
                'repeats' => $workout_pivot->repeats
            ];
        }

        return view('web.plans.start-workout',compact('workouts'));
    }//end of startWorkout
}
