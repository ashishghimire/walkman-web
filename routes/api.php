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
// Route::middleware('auth:api')->patch('/submit-score', 'AppUserController@submitScore')->name('api.submit-score');

Route::post('app-user', 'AppUserController@store')->name('api.store');
Route::patch('app-user', 'AppUserController@submitScore')->name('api.submit-score');
Route::get('leaderboard', 'AppUserController@leaderBoard')->name('api.leaderboard');