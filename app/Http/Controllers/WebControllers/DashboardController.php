<?php

namespace App\Http\Controllers\WebControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanCategory;

class DashboardController extends Controller
{
    public function index(){
        $plans = [];
        $plan_categories = PlanCategory::latest()->get();

        foreach($plan_categories as $index => $plan_category){
            $plans[$index] = $plan_category->plans()->latest()->paginate(3);
        }

        return view('web.dashboard',compact('plans','plan_categories'));
    }//end of index

    public function contact(Request $request){
        $request->validate([
            'name' => 'max:100|required',
            'email' => 'required|email',
            'subject' => 'required|max:100000',
        ]);
        session()->flash('success',__('site.message_sent'));
        return response()->json([
            'status'=>true,
        ]);
    }
}
