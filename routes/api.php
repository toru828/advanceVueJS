<?php
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', 'Auth\Api\LoginController@logout')->name('api.logout');
    Route::resources([
        'users' => Api\UsersController::class
    ]);
    Route::get('/search','SearchUsersController@search')->name('api.search');
});

Route::post('login', 'Auth\Api\LoginController@login')->name('api.login');
Route::get('login/exist_email/{email}', 'Auth\Api\LoginController@existEmail')->name('api.login.exist_email');
