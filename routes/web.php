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


Route::resource('scp', App\Http\Controllers\ScpController::class);

Route::resource('classe', App\Http\Controllers\ClasseController::class);

Route::resource('site', App\Http\Controllers\SiteController::class);

Route::resource('employee', App\Http\Controllers\EmployeeController::class);
