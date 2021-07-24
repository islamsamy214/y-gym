<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        //authentication
        Route::get('admin/login','Auth\LoginController@showLoginForm')->name('admin.login');
        Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login');
        Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');

        Route::group([
            'middleware'=>'adminAuth:users',
            'prefix'=>'dashboard'
        ],function () {
            //dashboard
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');

            //users route
            Route::resource('users', 'UserController');

            //article_categories route
            Route::resource('article_categories', 'ArticleCategoryController');

            //paln_categories route
            Route::resource('plan_categories', 'PlanCategoryController');

            //articles route
            Route::resource('articles', 'ArticleController');

            //plans route
            Route::resource('plans', 'PlanController');
            Route::post('plans/set_plan/{id}','PlanController@setPlan')->name('plans.set_plan');
            Route::get('plans/edit_plan/{id}','PlanController@editPlan')->name('plans.edit_plan');
            Route::post('plans/update_plan/{id}','PlanController@updatePlan')->name('plans.update_plan');

            //workouts route
            Route::resource('workouts', 'WorkoutController');

            //clients route
            Route::resource('clients', 'ClientController');
            Route::get('clients/payment/{id}','ClientController@getPayment')->name('clients.payment');
            Route::post('clients/payment/{id}','ClientController@payment')->name('clients.payment');
        });
    });
