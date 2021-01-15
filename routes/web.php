<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function(){

    Route::get('init', 'AppController@init');
    Route::get('all', 'AppController@getAll');
    Route::delete('/{id}', 'AppController@delete');
    Route::post('login', 'AppController@login');
    Route::post('register', 'AppController@register');
    Route::post('logout', 'AppController@logout');

});

Route::prefix('employee')->group(function(){

    Route::get('init', 'EmployeeController@getAllEmployees');
    Route::delete('/{id}', 'EmployeeController@delete');
    Route::put('/{id}', 'EmployeeController@update');
    Route::post('/new', 'EmployeeController@store');

});
Route::prefix('employees_payouts')->group(function(){

    Route::get('init/{id}', 'EmployeesPayoutController@getAllEmployeesPayoutsById');

    //Route::delete('/{id}', 'EmployeeController@delete');
   Route::put('/{id}', 'EmployeesPayoutController@update');
    //Route::post('/new', 'EmployeeController@store');

});

Route::prefix('employees_payouts_services')->group(function(){

    Route::get('init/{id}', 'EmployeesPayoutsServiceController@getAllEmployeesPayoutsServicesById');
    Route::put('/{id}', 'EmployeesPayoutsServiceController@update');
    
    //Route::delete('/{id}', 'EmployeeController@delete');
   // Route::put('/{id}', 'EmployeeController@update');
    //Route::post('/new', 'EmployeeController@store');

});
Route::prefix('service')->group(function(){

    Route::get('init', 'ServiceController@getAllServices');
    Route::delete('/{id}', 'ServiceController@delete');
    Route::put('/{id}', 'ServiceController@update');
    Route::post('/new', 'ServiceController@store');

});
Route::prefix('payout')->group(function(){

    Route::get('init' , 'PayoutController@showAll');
    Route::delete('/{id}', 'PayoutController@delete');
    Route::put('/{id}', 'PayoutController@update');
    Route::post('/new', 'PayoutController@store');
    Route::put('/json/{id}', 'PayoutController@updateJson');


});

