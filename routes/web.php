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
Auth::routes();

Route::get('/', 'HomeController@welcome');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('quotes/piechart_progress', 'QuotesController@progressPieChart');
Route::get('quotes/volume_chart', 'QuotesController@volumeChart');
Route::get('quotes/mrc_chart', 'QuotesController@mrcChart');
