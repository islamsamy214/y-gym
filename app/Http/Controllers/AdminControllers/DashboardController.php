<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index(){
        $clients_count = Client::count();
        $articles_count = Article::count();
        $plans_count = Plan::count();
        $clients_data = DB::select('SELECT YEAR(created_at) as year,MONTH(created_at) as month, COUNT(*) AS count FROM `clients` GROUP BY month');
        $subscribers_data = DB::select('SELECT YEAR(payed_date) as year,MONTH(payed_date) as month, COUNT(*) AS count FROM `clients` WHERE `payed_date` GROUP BY month');

        return view('admin.dashboard',compact('clients_data','subscribers_data','clients_count','articles_count','plans_count'));
    }
}
