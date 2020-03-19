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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::get('users', 'UserController@users');
Route::get('user/{id}', 'UserController@userbyId');
Route::post('auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');
Route::get('users/profile','UserController@profile')->middleware('auth:api');
Route::get('users/{id}','UserController@profile')->middleware('auth:api');
Route::post('post/add','PostController@add')->middleware('auth:api');
Route::put('post/{post}','PostController@update')->middleware('auth:api');
Route::delete('post/{post}','PostController@delete')->middleware('auth:api');