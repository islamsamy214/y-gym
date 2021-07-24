<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $workouts = Workout::where('name','like','%'.$request->search.'%')
                                    ->orWhere('muscle','like','%'.$request->search.'%')
                                    ->orWhere('equipment_type','like','%'.$request->search.'%')
                                    ->orWhere('level','like','%'.$request->search.'%')
                                    ->orWhere('exercise_type','like','%'.$request->search.'%')
                                    ->orWhereHas('user',function($q)use($request){
                                        $q->where('name','like','%'.$request->search.'%');
                                    })->where('id','!=',1)->latest()->paginate(10);
        }else{
            $workouts = Workout::where('id','!=',1)->latest()->paginate(10);
        }
        return view('web.workouts.index',compact('workouts','request'));
    }//end of index
}
