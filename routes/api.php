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

Route::group(['prefix' => '/auth'], function(){

    Route::post('/login','AuthController@login');
    Route::put('/changepass','AuthController@changepass');
    Route::post('/register','AuthController@register');

});


Route::group(['middleware' => 'api', 'prefix' => '/products'],function(){

    Route::get('/', 'ProductController@index');
    Route::post('/create', 'ProductController@create');
    Route::put('/update/{id}', 'ProductController@update');
    // Route::post('/update', 'ProductController@update');
    Route::delete('/delete/{id}', 'ProductController@delete');

});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
