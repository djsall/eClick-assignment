<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
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

Auth::routes();

Route::get('/home', HomeController::class)->name('home');

Route::resource('leaves', LeaveController::class);

Route::post('leaves/{leave}/accept', [LeaveController::class, 'accept'])->name('leave.accept');
