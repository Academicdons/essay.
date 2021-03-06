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

Route::get('/', 'GeneralController@index');
Route::get('/register_writer', 'GeneralController@registerWriter');
Route::get('/contact', 'GeneralController@contact')->name('contact');
//terms and conditions
Route::get('terms',function (){
   return view('terms_and_condition');
});


Auth::routes();

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/register_writer', '\App\Http\Controllers\Auth\RegisterController@registerWriter')->name('register_writer');

Route::get('/home', 'HomeController@index')->name('home')->middleware(['account_status']);
Route::post('/quick_register', 'Auth\RegisterController@quickRegister')->name('quick_register');

#Links for resume able uploads feature
Route::get('test','GeneralController@paypalTest')->name('test');
Route::get('send_sms','GeneralController@sendSms')->name('sendSms');
Route::get('account_pending','GeneralController@accountPending')->name('account_pending');

Route::get('get_session_files','GeneralController@sessionFiles')->name('get_session_files');
Route::get('get_disciplines/{group}','GeneralController@getDisciplines')->name('get_disciplines');
Route::get('get_ed_factor/{level}','GeneralController@getEdFactor')->name('get_ed_factor');
Route::post('upload_order_files','GeneralController@uploadOrderFiles')->name('upload_order_files');
Route::post('upload_order_files_main','GeneralController@uploadOrderFilesMain')->name('upload_order_files_main');
Route::get('delete_order_upload/{file}','GeneralController@deleteSessionFile')->name('delete_order_upload');



Route::group([],function () {
    Route::get('articles','GeneralController@articles')->name('articles');
    Route::get('read_article/{title?}','GeneralController@readArticle')->name('read_article')->where('title', '(.*)');;

});

Route::group(['middleware'=>'auth'],function () {

    Route::get('generate_referral_link','GeneralController@referralLink')->name('generate_referral_link');
});
//home profile routes
Route::group(['middleware'=>['auth','account_status']],function (){
    Route::get('profile','HomeController@profileView')->name('profile');
    Route::post('save_profile','HomeController@saveProfile')->name('save_profile');
    Route::post('update_picture','HomeController@updatePicture')->name('update_picture');
});

Route::group(['namespace'=>'Customer','prefix'=>'customer','as'=>'customer.','middleware'=>['auth','client']],function(){

    Route::group(['as'=>'orders.','prefix'=>'orders'],function(){
        Route::get('messages/{order}','OrdersController@messages')->name('messages');
        Route::post('save_message/{order}','OrdersController@saveMessage')->name('save_message');

        Route::post('review','OrdersController@review')->name('review');

        Route::post('revision/{order}','OrdersController@revision')->name('revision');
        Route::post('review/{order}','OrdersController@review')->name('review');
        Route::get('reviews/{order}','OrdersController@reviews')->name('reviews');
        Route::get('get_orders','OrdersController@getOrders')->name('get_orders');
        Route::get('fetch_order/{order}','OrdersController@fetchOrder')->name('fetch_order');
        Route::get('delete_file','OrdersController@deleteFile')->name('delete_file');
        Route::post('dispute_order','OrdersController@disputeOrder')->name('dispute_order');
        Route::get('fetch_disputes/{order_id}','OrdersController@fetchDisputes')->name('fetch_disputes');

        Route::get('create','OrdersController@create')->name('create');
        Route::post('store','OrdersController@store')->name('store');
        Route::get('pay/{order}','OrdersController@pay')->name('pay');
        Route::post('pay/process','OrdersController@processPay')->name('pay.process');
        Route::get('mark_revised_order_as_complete/{order}','OrdersController@markRevisedOrderAsComplete')->name('mark_revised_order_as_complete');
    });

    Route::group(['middleware'=>['account_status']],function (){

        #Reoutes regarding to orders
        Route::group(['as'=>'orders.','prefix'=>'orders'],function () {
            Route::get('list','OrdersController@list')->name('list');
            Route::get('view/{order}','OrdersController@view')->name('view');
        });

    });

});
Route::get('/testing', function (){
    return view('layouts.admin');
});



#Routes controlling writers workspace
Route::Group(['prefix' => 'writer', 'namespace' => 'Writer', 'as' => 'writer.', 'middleware' => ['auth','account_status']],function(){

    Route::get('mark_all_notification_As_read','ProfileController@markNotAsRead')->name('mark_all_notification_As_read');

    Route::group(['as'=>'dashboard.','prefix'=>'dashboard'],function() {
        Route::get('/', 'DashboardController@index')->name('index');
    });


        #Orders routes
    Route::group(['as'=>'orders.','prefix'=>'orders'],function(){
        Route::get('/available', 'OrdersController@availableOrders')->name('available');
        Route::get('/recent', 'OrdersController@getRecentOrders')->name('recent');
        Route::get('/all', 'OrdersController@allOrders')->name('all');
        Route::get('/user_orders', 'OrdersController@getUsersOrders')->name('user_orders');
        Route::get('/finished', 'OrdersController@finished')->name('finished');
        Route::get('/finished_orders', 'OrdersController@finishedOrders')->name('finished_orders');
        Route::get('/view/{order}', 'OrdersController@viewOrder')->name('view');
        Route::get('/revisions', 'OrdersController@revisions')->name('revisions');
        Route::get('/bargains', 'OrdersController@bargains')->name('bargains');
        Route::get('/reviews/{order}', 'OrdersController@orderReviews')->name('reviews');
        Route::get('/messages/{order}', 'OrdersController@getMessages')->name('messages');
        Route::post('/save_messages/{order}', 'OrdersController@saveMessage')->name('save_messages');
        Route::post('/upload/{order}', 'OrdersController@saveFile')->name('upload');
        Route::get('/available_orders_json','OrdersController@availableOrdersJson');
        Route::get('view/{order}','OrdersController@view')->name('view');
        Route::post('review','OrdersController@review')->name('review');
        Route::get('place_bid/{order_id}','OrdersController@placeBid')->name('place_bid');
        Route::get('mark_as_complete/{order}','OrdersController@markAsComplete')->name('mark_as_complete');
        Route::get('get_revision_deadline/{order_id}','OrdersController@getRevisionDeadline')->name('get_revision_deadline');
        Route::get('mark_order_complete/{order}','OrdersController@markCompletedOrder')->name('mark_order_complete');


    });



    Route::group(['as'=>'profile.','prefix'=>'profile'],function (){
        Route::get('/', 'ProfileController@index')->name('index');
        Route::get('payments','ProfileController@payments')->name('payments');
        Route::post('store_payments','ProfileController@storePayments')->name('store_payments');
        Route::post('update_profile','ProfileController@updateUser')->name('update_profile');
        Route::post('update_user_profile','ProfileController@updateUserProfile')->name('update_user_profile');
    });

    //announcement routes
    Route::get('check_announcements','AnnouncementController@getAnnouncementsJson')->name('check_announcements');
    Route::get('change_announcement','AnnouncementController@toggleAnnouncement')->name('change_announcement');

    //user discipline routes
    Route::get('get_all_disciplines','UserDisciplineController@getAllDisciplines')->name('get_all_disciplines');
    Route::post('update_disciplines','UserDisciplineController@updateDisciplines')->name('update_disciplines');
    Route::get('delete_user_discipline/{userDiscipline}','UserDisciplineController@deleteUserDiscipline')->name('delete_user_discipline');
});


//Backend Routes:
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.', 'middleware' => ['admin', 'auth','account_status']], function () {
//   /dashboard
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('get_clients_json','DashboardController@getClientsJson')->name('get_clients_json');
    Route::get('get_writers_json','DashboardController@getWritersJson')->name('get_writers_json');
    Route::get('get_date_order_json','DashboardController@getOrdersSum')->name('get_date_order_json');
    Route::get('/discipline/index', 'DashboardController@discipline')->name('discipline');
    Route::get('/education_level/index', 'DashboardController@educationLevel')->name('education_level');
    Route::get('/paper_type/index', 'DashboardController@paperType')->name('paper_type');
    Route::get('mark_all_notification_As_read','DashboardController@markNotAsRead')->name('mark_all_notification_As_read');

    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
        Route::get('/suggest_writer', 'GeneralController@suggestWriters')->name('suggest_writer');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/domains', 'SettingsController@getAllDomains')->name('domains');
        Route::post('/add_domain', 'SettingsController@saveDomain')->name('add_domain');
        Route::get('/delete_domain/{domain}', 'SettingsController@deleteDomain')->name('delete_domain');
        Route::get('/edit_domain/{domain}', 'SettingsController@editDomain')->name('edit_domain');
        Route::get('/system', 'SettingsController@systemSettings')->name('system');
        Route::get('/usage', 'SettingsController@usageSettings')->name('usage');
        Route::post('/store_system', 'SettingsController@storeSystemSettings')->name('store_system');
        Route::post('/save_stats', 'SettingsController@storeUsageSettings')->name('save_stats');
    });

    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::get('/', 'AccountsController@index')->name('all');
        Route::get('/users', 'AccountsController@users')->name('users');
        Route::get('/invoice/{user}', 'AccountsController@invoice')->name('invoice');
        Route::get('/preview', 'AccountsController@previewInvoice')->name('preview');
        Route::get('/data', 'AccountsController@getData')->name('data');
        Route::get('/bargains', 'AccountsController@bargains')->name('bargains');
        Route::post('/pay_orders', 'AccountsController@payOrder')->name('pay_orders');

    });


    Route::group(['prefix' => 'announcement', 'as' => 'announce.'], function () {
        Route::get('/', 'AnnouncementController@index')->name('index');
        Route::get('/new', 'AnnouncementController@newAnnouncement')->name('new');
        Route::post('/store', 'AnnouncementController@store')->name('store');
        Route::get('/mark_as_inactive/{id}', 'AnnouncementController@markAsInActive')->name('mark_as_inactive');
    });
    
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/all', 'OrdersController@getOrders')->name('all');
        Route::get('/search', 'OrdersController@search')->name('search');
        Route::get('/new', 'OrdersController@newOrder')->name('new');
        Route::post('/store', 'OrdersController@store')->name('store');
        Route::post('/review', 'OrdersController@review')->name('review');
        Route::post('/manual_assign', 'OrdersController@manualAssign')->name('manual_assign');
        Route::post('/save_file', 'OrdersController@saveFile')->name('save_file');
        Route::get('/delete/{order}', 'OrdersController@deleteOrder')->name('delete');
        Route::get('/edit/{order}', 'OrdersController@editOrder')->name('edit');
        Route::get('/view/{order}', 'OrdersController@viewOrder')->name('view');
        Route::get('/reviews/{order}', 'OrdersController@orderReviews')->name('reviews');
        Route::get('/chat_data/{order}', 'OrdersController@getChatData')->name('chat_data');
        Route::get('/messages/{order}', 'OrdersController@getChatMessages')->name('messages');
        Route::get('/bargains/{order}', 'OrdersController@bargains')->name('bargains');
        Route::get('/delete_bargain/{bargain}', 'OrdersController@deleteBargains')->name('delete_bargain');
        Route::post('/save_messages/{order}', 'OrdersController@saveChatMessage')->name('save_messages');
        Route::post('/create_bargain/{order}', 'OrdersController@saveBargain')->name('create_bargain');
        Route::get('/get_order_bids/{order}', 'OrdersController@getOrderBids')->name('get_order_bids');
        Route::get('/assign_user_bid/{order_id}/{user_id}', 'OrdersController@assignUserBid')->name('assign_user_bid');
        Route::post('/upload_file/{order}', 'OrdersController@saveFile')->name('upload_file');
        Route::post('/advance_uploads/{order}', 'OrdersController@advancedUploads')->name('advance_uploads');
        Route::get('/verify_file/{attachment}', 'OrdersController@verifyFile')->name('verify_file');
        Route::get('/mark_completed_revision/{order}', 'OrdersController@markCompletedOrder')->name('mark_completed_revision');
        Route::post('dispute_order','OrdersController@disputeOrder')->name('dispute_order');
        Route::get('fetch_disputes/{order_id}','OrdersController@fetchDisputes')->name('fetch_disputes');
        Route::get('toggle_auto_assign/{status}','OrdersController@toggleAutoAssign')->name('toggle_auto_assign');
        Route::post('revise_order','OrdersController@reviseOrder')->name('revise_order');


        //send email
        Route::post('send_email_','OrdersController@sendEmail');
    });

    Route::group(['prefix' => 'discipline', 'as' => 'discipline.'], function () {
        Route::get('/', 'DashboardController@discipline')->name('index');
        Route::post('/add', 'DisciplineController@add')->name('add');
        Route::get('/delete/{discipline}', 'DisciplineController@deleteDiscipline')->name('delete');
        Route::get('/edit/{discipline}', 'DisciplineController@editDiscipline');

        //group routes
        Route::get('/group','DisciplineController@groupsView')->name('group');
        Route::post('/add_grouping','DisciplineController@saveGrouping')->name('add_grouping');
        Route::get('/delete_group/{group}', 'DisciplineController@deleteGroup')->name('delete_group');
        ROute::get('edit_group/{group}','DisciplineController@editGroup');
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
        Route::get('/profile', 'UsersController@getProfile')->name('profile');
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


    //blog routes
    Route::group(['prefix'=>'blog','as'=>'blog.'],function (){
       Route::get('new','BlogController@newBlogView')->name('new');
       Route::get('all_blogs','BlogController')->name('all_blogs');
       Route::post('new_blog','BlogController@newBlog')->name('new_blog');

    });
});
