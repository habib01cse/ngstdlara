<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::any('register', 'userController@register', 'register');
Route::any('login', 'userController@login', 'login');

Route::any('add', 'userController@add', 'add');
Route::any('update', 'userController@update', 'update');
Route::any('delete', 'userController@delete', 'delete');
Route::any('show', 'userController@show', 'show');

Route::any('task/add', 'taskController@add', 'add');
Route::any('task/update', 'taskController@update', 'update');
Route::any('task/delete', 'taskController@delete', 'delete');
Route::any('task/view', 'taskController@show', 'show');
Route::any('task/show', 'taskController@show', 'show');

Route::any('products/add', 'ProductController@add');
Route::any('products/update', 'ProductController@update');
Route::any('products/delete', 'ProductController@delete');
Route::any('products/show', 'ProductController@show');
Route::any('products/get-products', 'ProductController@getProducts');
