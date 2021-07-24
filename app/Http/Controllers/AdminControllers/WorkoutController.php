<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:workouts_read'])->only('index');
        $this->middleware(['permission:workouts_create'])->only('store');
        $this->middleware(['permission:workouts_update'])->only('update');
        $this->middleware(['permission:workouts_delete'])->only('destroy');
    }//end of constructor


    public function index(Request $request)
    {
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

        return view('admin.workouts.index',compact('workouts','request'));
    }//end of index



    public function store(WorkoutRequest $request)
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

            $img->save(public_path('images/workouts/'.$img_name),60);

            $request_data['image'] = $img_name;
        }

        Workout::create($request_data);
        session()->flash('success',__('site.workout_created'));
        return response()->json([
            'status'=>true,
        ]);
    }//end of create



    public function edit(Workout $workout)
    {
        return view('admin.workouts.edit',compact('workout'));
    }//end of edit


    public function update(WorkoutRequest $request, Workout $workout)
    {
        $request->validated();

        $request_data = $request->except('image');
        $request_data['user_id'] = auth()->user()->id;

        if($request->image){
            if($workout->image){
                Storage::disk('public_image')->delete('workouts/'.$workout->image);
            }

            $img = Image::make($request->image);
            $img->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img_name = rand().'.'.$request->image->getClientOriginalExtension();

            $img->save(public_path('images/workouts/'.$img_name),60);

            $request_data['image'] = $img_name;
        }

        $workout->update($request_data);
        session()->flash('success',__('site.workout_updated'));
        return redirect()->route('workouts.index');
    }//end of update


    public function destroy(Workout $workout)
    {
        if($workout->image){
            Storage::disk('public_image')->delete('workouts/'.$workout->image);
        }
        $workout->delete();
        session()->flash('success',__('site.workout_deleted'));
        return redirect()->route('workouts.index');
    }//end of destroy
}
