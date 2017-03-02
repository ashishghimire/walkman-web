<?php

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
Route::auth();

Route::get('/', 'HomeController@index');

Route::resource('user', 'UserController', ['except' => ['create', 'store']]);

Route::get('user/{user}/change-password', 'UserController@changePassword')->name('user.change-password');

Route::patch('user/{user}/change-password', 'UserController@updatePassword')->name('user.update-password');

Route::get('profile_pictures/{image}', function ($image) {
    if (!File::exists($image = storage_path("app/profile_pictures/{$image}"))) abort(404);
    $returnImage = Image::make($image);
    return $returnImage->response();
});
