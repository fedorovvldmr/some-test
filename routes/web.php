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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    
    Route::get('/news', 'NewsController@index')->name('news');
    Route::get('/news/{id}', 'NewsController@show')->name('news.show');
    
    Route::get('/photos', 'PhotoController@index')->name('photos');
    Route::post('/photos/create', 'PhotoController@create')->name('photos.create');
    
    Route::namespace('Ajax')->prefix('ajax')->name('ajax')->group(function () {
        Route::post('/rating/inc', 'RatingController@inc');
        Route::post('/rating/dec', 'RatingController@dec');
        
        Route::get('/news/delete/{id}', 'NewsController@delete')->name('news.delete');
        Route::post('/news/create', 'NewsController@createOrEdit')->name('news.create');
        Route::post('/news/edit/{id}', 'NewsController@createOrEdit')->name('news.edit');
    
        Route::get('/photo/delete/{id}', 'PhotoController@delete')->name('news.delete');
    });
});