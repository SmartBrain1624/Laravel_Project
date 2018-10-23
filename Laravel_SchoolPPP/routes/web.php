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

Route::get('/', 'PagesController@home');

Route::get('school/statistic', 'SchoolController@index');
Route::post('school/statistic', 'SchoolController@save');

Route::get('school/{id}/graph', 'SchoolController@graph');
Route::get('school/{id}/data', 'SchoolController@data');
Route::get('school/graphData', 'SchoolController@graphData');

Route::get('school/{id}/list', 'SchoolController@statisticsList')->name('list');

Route::get('school/statistic/{id}/edit', 'SchoolController@statisticEdit');
Route::post('school/statistic/{id}/edit', 'SchoolController@statisticEditSave');
Route::get('school/statistic/{id}/delete', 'SchoolController@statisticDelete');

Route::post('school/{id}/benchmark', 'SchoolController@saveBenchmark');

Route::get('school/{id}/download', 'SchoolController@download');

Route::get('email', 'MessageController@index');
Route::post('email', 'MessageController@send');

Route::get('school/add', 'SchoolController@add');
Route::post('school/create', 'SchoolController@create');

//Route::get('email1', 'MessageController@send');