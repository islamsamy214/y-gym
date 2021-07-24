<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        //authentication
        Route::get('login','Auth\LoginController@showLoginForm')->name('web.login');
        Route::post('login', 'Auth\LoginController@login')->name('web.login');
        Route::get('register','Auth\RegisterController@showRegistrationForm')->name('web.register');
        Route::post('register', 'Auth\RegisterController@register')->name('web.register');
        Route::post('logout', 'Auth\LoginController@logout')->name('web.logout');

        //dashboard
        Route::get('/', 'DashboardController@index')->name('web.dashboard');
        Route::post('/', 'DashboardController@contact')->name('web.dashboard');

        //workouts
        Route::get('workouts','WorkoutController@index')->name('web.workouts');

        //plans
        Route::get('plans','PlanController@index')->name('web.plans');
        Route::get('plans/show/{id}','PlanController@show')->name('web.plans.show');
        Route::get('plans/show/{id}/{week}/{day}','PlanController@showWorkout')->name('web.plans.show.day');

        //articles
        Route::get('articles','ArticleController@index')->name('web.articles');

        Route::group([
            'middleware' => 'webAuth:clients'
        ], function(){
            //plans
            Route::get('plans/start','PlanController@start')->name('web.plans.start');
            Route::get('plans/start/{plan_id}/{week}/{day}/{client_id}','PlanController@startWorkout')->name('web.plans.start.day');

            //clients
            Route::resource('clients', 'ClientController')->names('web.clients')->except(['create','show','store','edit']);
        });

    });
