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

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testing', function (){
    return view('layouts.admin');
});

//Backend Routes:
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/discipline/index', 'DashboardController@discipline')->name('discipline');
    Route::get('/education_level/index', 'DashboardController@educationLevel')->name('education_level');
    Route::get('/paper_type/index', 'DashboardController@paperType')->name('paper_type');

    Route::group(['prefix' => 'announcement', 'as' => 'announce.'], function () {
        Route::get('/', 'AnnouncementController@index')->name('index');
        Route::get('/new', 'AnnouncementController@newAnnouncement')->name('new');
        Route::post('/store', 'AnnouncementController@store')->name('store');
    });
    
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/new', 'OrdersController@newOrder')->name('new');
        Route::post('/store', 'OrdersController@store')->name('store');
        Route::get('/delete/{order}', 'OrdersController@deleteOrder')->name('delete');
        Route::get('/edit/{order}', 'OrdersController@editOrder')->name('edit');
    });

    Route::group(['prefix' => 'discipline', 'as' => 'discipline.'], function () {
        Route::get('/', 'DashboardController@discipline')->name('index');
        Route::post('/add', 'DisciplineController@add')->name('add');
        Route::get('/delete/{discipline}', 'DisciplineController@deleteDiscipline')->name('delete');
        Route::get('/edit/{discipline}', 'DisciplineController@editDiscipline');
    });

    Route::group(['prefix' => 'education_level', 'as' => 'education_level.'], function () {
        Route::get('/', 'DashboardController@educationLevel')->name('index');
        Route::post('/add', 'EdLevelController@add')->name('add');
        Route::get('/delete/{educationLevel}', 'EdLevelController@deleteEdLevel')->name('delete');
        Route::get('/edit/{educationLevel}', 'EdLevelController@editEdLevel');
    });

    Route::group(['prefix' => 'paper_type', 'as' => 'paper_type.'], function () {
        Route::post('/add', 'PaperTypeController@add')->name('add');
        Route::get('/delete/{paperType}', 'PaperTypeController@deletePaperType')->name('delete');
        Route::get('/', 'DashboardController@paperType')->name('index');
        Route::get('/edit/{paperType}', 'PaperTypeController@editPaperType');
    });
});