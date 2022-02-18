<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users', 'UserController@CreateUser');
Route::get('/users', 'UserController@ReadUser');
Route::put('/users/{id}', 'UserController@UpdateUser');
Route::delete('/users/{id}', 'UserController@DeleteUser');
Route::post('/users/login','UserController@LogInUser');
Route::post('/users/authorization','UserController@Authorization');
