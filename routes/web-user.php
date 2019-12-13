<?php
Route::prefix('account-setting')->namespace('UserSetting')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', 'HomeController@index')->name('get_user_setting_index_route');
    Route::post('/change-user-password', 'HomeController@changePassword')->name('post_user_setting_change_password_route');
    Route::post('/update-user-subcribe', 'HomeController@updateSucribe')->name('post_user_subcribe_route');
    // route personal trading
    Route::post('/delete-personal-trading', 'PersonalTradingController@postDelete')->name('post_personal_trading_delete_route');
    // real estate
    Route::post('/delete-real-estate', 'RealEstateController@postDelete')->name('post_real_estate_delete_route');
    // job searching
    Route::post('/delete-job-searching', 'JobSearchingController@postDelete')->name('post_job_searching_delete_route');
    // bullboard
    Route::post('/delete-bullboard', 'BullboardController@postDelete')->name('post_bullboard_delete_route');
    // user profile
    Route::get('/edit-profile', 'UserProfileController@getEdit')->name('get_user_profile_edit_route');
    Route::post('/edit-profile', 'UserProfileController@postEdit')->name('post_user_profile_edit_route');
    Route::post('/upload-avatar', 'HomeController@uploadAvatar')->name('post_upload_avatar_route');

    // notification
    Route::get('/notification', 'HomeController@getNotification')->name('get_notification_route');
    Route::get('/notification-detail/{notifyId}', 'HomeController@getDetailNotification')->name('get_detail_notification_route');
    Route::post('/notification-read-all', 'HomeController@postReadAllNotification')->name('post_read_all_notification_route');
    Route::post('/notification-delete', 'HomeController@deleteNotification')->name('post_delete_notification_route');
    Route::post( '/notification-update-status', 'HomeController@notifyStatus')->name('post_update_notify_status_route');

    Route::prefix('town')->group(function() {
        // Route::get('/', 'TownController@index')->name('get_user_setting_town_index_route');
        Route::post('/delete', 'TownController@postDelete')->name('post_town_delete_route');
        Route::post('/change-status', 'TownController@changeStatus')->name('post_town_change_status_route');
        Route::post('/load-data-table', 'TownController@loadDataTable')->name('post_town_data_table_route');
    });

    Route::prefix('saved-link')->group(function() {
        Route::get('/', 'SavedLinkController@viewSavedLink')->name('get_view_saved_link');

        Route::post('/add', 'SavedLinkController@saveLink')->name('run_save_link');

        Route::post('/unsavelink', 'SavedLinkController@unsaveLink')->name('unsavelink');

        Route::get('/load-data-more', 'SavedLinkController@loadDataMore')->name('get_saved_link_more_data_route');

        Route::get('/auto-dropdown-saved-link', 'SearchController@autoDropDownSavedLink')->name('autocomplete_saved_link');

        Route::get('/auto-refresh-time', 'SavedLinkController@refreshTimeAgo')->name('run_auto_refresh_time_ago');
    });

    Route::prefix('business')->group(function() {
        Route::get('/', 'BusinessController@index')->name('get_user_setting_business_index_route');
        Route::post('/delete', 'BusinessController@postDelete')->name('post_business_delete_route');
        Route::post('/change-status', 'BusinessController@changeStatus')->name('post_business_change_status_route');
        Route::post('/load-data-table', 'BusinessController@loadDataTable')->name('post_town_data_table_route');
    });
});
