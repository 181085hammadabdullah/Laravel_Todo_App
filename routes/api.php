<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/addtodo','TodoController@store');
Route::get('/getall','TodoController@index');
Route::get('/getone/{id}','TodoController@edit');
Route::put('/update/{id}','TodoController@update');
Route::delete('/delete/{id}','TodoController@destroy');
