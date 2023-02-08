<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;
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


Route::middleware('auth')->group(function () {

	Route::get('/', HomeController::class)->name('home');

	Route::resource('user', UserController::class, [
		'only' => [
			'index',
			'edit',
			'update',
			'destroy'
		]
	])->middleware("manager");

	Route::resource('leave', LeaveController::class, [
		'except' => [
			'show',
			'update',
		]
	]);

	Route::post('leave/{leave}/accept', [
		LeaveController::class,
		'accept'
	])->name('leave.accept');
});
