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

#Links for resume able uploads feature
Route::get('get_session_files','GeneralController@sessionFiles')->name('get_session_files');
Route::get('upload_order_files','GeneralController@uploadOrderFiles')->name('upload_order_files');
Route::get('upload_order_files_main','GeneralController@uploadOrderFilesMain')->name('upload_order_files_main');


Route::group(['namespace'=>'Customer','prefix'=>'customer','as'=>'customer.'],function(){

    Route::group(['name'=>'orders.','prefix'=>'orders'],function(){
        Route::get('create','OrdersController@create')->name('create');
        Route::get('store','OrdersController@store')->name('store');
    });

});
Route::get('/testing', function (){
    return view('layouts.admin');
});



#Routes controlling writers workspace
Route::Group(['prefix' => 'writer', 'namespace' => 'Writer', 'as' => 'writer.', 'middleware' => ['auth']],function(){

    #Orders routes
    Route::group(['as'=>'orders.','prefix'=>'orders'],function(){
        Route::get('/available', 'OrdersController@availableOrders')->name('available');
        Route::get('/all', 'OrdersController@allOrders')->name('all');
        Route::get('/user_orders', 'OrdersController@getUsersOrders')->name('user_orders');
        Route::get('/view/{order}', 'OrdersController@viewOrder')->name('view');
        Route::get('/reviews/{order}', 'OrdersController@orderReviews')->name('reviews');
        Route::get('/messages/{order}', 'OrdersController@getMessages')->name('messages');
        Route::post('/save_messages/{order}', 'OrdersController@saveMessage')->name('save_messages');
        Route::post('/upload_file/{order}', 'OrdersController@saveFile')->name('upload_file');
    });

});


//Backend Routes:
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/discipline/index', 'DashboardController@discipline')->name('discipline');
    Route::get('/education_level/index', 'DashboardController@educationLevel')->name('education_level');
    Route::get('/paper_type/index', 'DashboardController@paperType')->name('paper_type');

    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
        Route::get('/suggest_writer', 'GeneralController@suggestWriters')->name('suggest_writer');
    });

    Route::group(['prefix' => 'announcement', 'as' => 'announce.'], function () {
        Route::get('/', 'AnnouncementController@index')->name('index');
        Route::get('/new', 'AnnouncementController@newAnnouncement')->name('new');
        Route::post('/store', 'AnnouncementController@store')->name('store');
    });
    
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/all', 'OrdersController@getOrders')->name('all');
        Route::get('/new', 'OrdersController@newOrder')->name('new');
        Route::post('/store', 'OrdersController@store')->name('store');
        Route::post('/manual_assign', 'OrdersController@manualAssign')->name('manual_assign');
        Route::get('/delete/{order}', 'OrdersController@deleteOrder')->name('delete');
        Route::get('/edit/{order}', 'OrdersController@editOrder')->name('edit');
        Route::get('/view/{order}', 'OrdersController@viewOrder')->name('view');
        Route::get('/reviews/{order}', 'OrdersController@orderReviews')->name('reviews');
        Route::get('/chat_data/{order}', 'OrdersController@getChatData')->name('chat_data');
        Route::get('/messages/{order}', 'OrdersController@getChatMessages')->name('messages');
        Route::post('/save_messages/{order}', 'OrdersController@saveChatMessage')->name('save_messages');
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

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/list/{type}', 'UsersController@users')->name('all');
        Route::get('/create', 'UsersController@create')->name('create');
        Route::post('/store', 'UsersController@store')->name('store');
        Route::get('/edit/{user}', 'UsersController@editUser')->name('edit');
        Route::get('/status/{status}/{user}', 'UsersController@toggleStatus')->name('status');

    });

    Route::group(['prefix' => 'paper_type', 'as' => 'paper_type.'], function () {
        Route::post('/add', 'PaperTypeController@add')->name('add');
        Route::get('/delete/{paperType}', 'PaperTypeController@deletePaperType')->name('delete');
        Route::get('/', 'DashboardController@paperType')->name('index');
        Route::get('/edit/{paperType}', 'PaperTypeController@editPaperType');
    });
});
