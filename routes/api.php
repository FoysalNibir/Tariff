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


Route::post('login', 'API\PassportController@login');
 
Route::post('register', 'API\PassportController@register');
 
Route::get('rules', array('as' => 'rules', 'uses' => 'API\PassportController@rules'));
Route::get('tariffs', array('as' => 'tariffs', 'uses' => 'API\PassportController@tariffs'));
Route::get('sros', array('as' => 'sros', 'uses' => 'API\PassportController@sros'));
Route::post('sros', array('as' => 'sros.post', 'uses' => 'API\PassportController@postsros'));
Route::get('sros/yearlist', array('as' => 'sros.year', 'uses' => 'API\PassportController@srosYearlist'));
Route::get('sros/{year}', array('as' => 'sros.year', 'uses' => 'API\PassportController@srosByYear'))->where('year', '[0-9]+');


Route::group(['middleware' => 'auth:api'], function(){
 
	Route::post('get-details', 'API\PassportController@getDetails');
 
});