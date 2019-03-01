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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testing', function (){
    return view('layouts.admin');
});

//Backend Routes:
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/discipline', 'DashboardController@discipline')->name('discipline');
    Route::get('/education_level', 'DashboardController@educationLevel')->name('education_level');
    Route::get('/paper_type', 'DashboardController@paperType')->name('paper_type');

    Route::group(['prefix' => 'discipline', 'as' => 'discipline.'], function () {
        Route::post('/add', 'DisciplineController@add')->name('add');
        Route::get('/delete/{discipline}', 'DisciplineController@deleteDiscipline')->name('delete');
    });

    Route::group(['prefix' => 'education_level', 'as' => 'education_level.'], function () {
        Route::post('/add', 'EdLevelController@add')->name('add');
        Route::get('/delete/{educationLevel}', 'EdLevelController@deleteEdLevel')->name('delete');
    });

    Route::group(['prefix' => 'paper_type', 'as' => 'paper_type.'], function () {
        Route::post('/add', 'PaperTypeController@add')->name('add');
        Route::get('/delete/{paperType}', 'PaperTypeController@deletePaperType')->name('delete');
    });
});