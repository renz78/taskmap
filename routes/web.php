<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\MarkerController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('main.index');
    Route::post('addmaker', 'MarkerController@store')->name('marker.store');
    Route::get('/marker', 'MarkerController@index')->name('marker.index');
});



