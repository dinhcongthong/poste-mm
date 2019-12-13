<?php
Route::prefix('admin')->namespace('Admin')->middleware(['auth.editor', 'verified'])->group(function() {
    Route::get('/', 'HomeController@index');

    // Sitemap Management
    Route::prefix('sitemap')->group(function() {
        Route::get('/', 'SiteMapController@index')->name('get_site_map_index_ad_route');
    });

    // Admin Advertisiment Management
    Route::prefix('ads')->group(function() {
        Route::get('/', 'AdsController@index')->name('get_ads_index_ad_route');
        Route::get('/add', 'AdsController@getUpdate')->name('get_ads_add_ad_route');
        Route::post('/add', 'AdsController@postUpdate')->name('post_ads_add_ad_route');
        Route::get('/edit/{id}', 'AdsController@getUpdate')->name('get_ads_edit_ad_route');
        Route::post('/edit/{id}', 'AdsController@postUpdate')->name('post_ads_edit_ad_route');

        Route::post('/change-status', 'AdsController@changeStatus')->name('post_ads_change_status_ad_route');
        Route::post('/update-inform', 'AdsController@updateInform')->name('post_ads_update_inform_ad_route');

        Route::post('/load-data-table', 'AdsController@loadDataTable')->name('post_ads_data_table_route');
        

        //Admin Ads Position Mangement
        Route::prefix('/position')->group(function() {
            Route::get('/', 'AdsController@getPosition')->name('get_ads_position_ad_route');
            Route::get('/add', 'AdsController@getAddPosition')->name('get_ads_position_add_ad_route');
            Route::post('/add', 'AdsController@postAddPosition')->name('post_ads_position_add_ad_route');
            Route::get('/edit/{id}', 'AdsController@getAddPosition')->name('get_ads_position_edit_ad_route');
            Route::post('/edit/{id}', 'AdsController@postAddPosition')->name('post_ads_position_edit_ad_route');

            Route::post('change-how-to-show', 'AdsController@ajaxChangeHowToShow')->name('post_ajax_position_change_how_to_show_route');
            Route::post('change-version-show', 'AdsController@ajaxChangeVersionShow')->name('post_ajax_position_change_version_show_route');

            Route::post('/load-data-table-position', 'AdsController@loadPositionDataTable')->name('post_ads_position_data_table_route');
        });
    });


    // Admin Gallery Management
    Route::prefix('gallery')->group(function() {
        Route::get('/', 'GalleryController@index')->name('get_gallery_index_ad_route');
        Route::get('/add', 'GalleryController@getUpdate')->name('get_gallery_update_ad_route');
        Route::post('/add', 'GalleryController@postUpdate')->name('post_gallery_update_ad_route');
        Route::get('/delete/{id}', 'GalleryController@getDelete')->name('get_gallery_delete_ad_route');
        Route::post('/delete/{id}', 'GalleryController@postDelete')->name('post_gallery_delete_ad_route');
    });

    // Admin Dailyinfo Management
    Route::prefix('dailyinfo')->group(function() {
        Route::get('/', 'DailyinfoController@index')->name('get_dailyinfo_index_ad_route');
        Route::get('/add', 'DailyinfoController@getUpdate')->name('get_dailyinfo_add_ad_route');
        Route::post('/add', 'DailyinfoController@postUpdate')->name('post_dailyinfo_add_ad_route');
        Route::get('/edit/{id}', 'DailyinfoController@getUpdate')->name('get_dailyinfo_edit_ad_route');
        Route::post('/edit/{id}', 'DailyinfoController@postUpdate')->name('post_dailyinfo_edit_ad_route');
        Route::post('/delete', 'DailyinfoController@postDelete')->name('post_dailyinfo_delete_ad_route');
        Route::get('/preview/{article}', 'DailyinfoController@getPreview')->name('get_dailyinfo_preview_ad_route');

        Route::post('/change-status', 'DailyinfoController@updateStatus')->name('post_dailyinfo_update_status_ad_route');
        Route::get('/test', 'DailyinfoController@test');

        Route::post('/load-data-table', 'DailyinfoController@loadDataTable')->name('post_dailyinfo_data_table_route');
    });

    // Admin Lifetip Management
    Route::prefix('lifetip')->group(function() {
        Route::get('/', 'LifetipController@index')->name('get_lifetip_index_ad_route');
        Route::get('/add', 'LifetipController@getUpdate')->name('get_lifetip_add_ad_route');
        Route::post('/add', 'LifetipController@postUpdate')->name('post_lifetip_add_ad_route');
        Route::get('/edit/{id}', 'LifetipController@getUpdate')->name('get_lifetip_edit_ad_route');
        Route::post('/edit/{id}', 'LifetipController@postUpdate')->name('post_lifetip_edit_ad_route');
        Route::post('/delete', 'LifetipController@postDelete')->name('post_lifetip_delete_ad_route');
        Route::post('/change-status', 'LifetipController@changeStatus')->name('post_lifetip_change_status_ad_route');
        Route::get('/preview/{article}', 'LifetipController@getPreview')->name('get_lifetip_preview_ad_route');

        Route::post('/load-data-table', 'LifetipController@loadDataTable')->name('post_lifetip_data_table_route');
    });

    //Admin B2B Management
    Route::prefix('business')->group(function() {
        Route::get('/', 'BusinessController@index')->name('get_business_index_ad_route');
        Route::get('/update', 'BusinessController@index')->name('get_business_upate_ad_route');

        route::post('set-owner', 'BusinessController@postSetOwner')->name('post_business_set_owner_ad_route');
        route::post('remove-owner', 'BusinessController@postRemoveOwner')->name('post_business_remove_owner_ad_route');
        route::post('change-status', 'BusinessController@postChangeStatus')->name('post_business_change_status_ad_route');

        Route::get('/edit-info/{town_id}', 'BusinessController@getEditInfo')->name('get_business_edit_info');
        Route::post('/edit-info/{town_id}', 'BusinessController@postEditInfo')->name('post_business_edit_info');

        Route::post('/load-data-table', 'BusinessController@loadDataTable')->name('post_business_data_table_route');
    });

    // admin B2C Management
    Route::prefix('poste-town')->group(function() {
        Route::get('/', 'PosteTownController@index')->name('get_poste_town_index_ad_route');

        // Route::get('/set-owner/{article_id}', 'PosteTownController@getSetOwner')->name('get_poste_town_set_owner_ad_route');
        Route::post('/set-owner', 'PosteTownController@postSetOwner')->name('post_poste_town_set_owner_ad_route');
        route::post('remove-owner', 'PosteTownController@postRemoveOwner')->name('post_poste_town_remove_owner_ad_route');
        Route::post('/set-customer', 'PosteTownController@postSetCustomer')->name('post_poste_town_set_customer_ad_route');

        Route::get('/edit-info/{town_id}', 'PosteTownController@getEditInfo')->name('get_poste_town_edit_info');
        Route::post('/edit-info/{town_id}', 'PosteTownController@postEditInfo')->name('post_poste_town_edit_info');

        Route::post('/change-status', 'PosteTownController@postChangeStatus')->name('post_ajax_change_status');

        Route::post('/load-data-table', 'PosteTownController@loadDataTable')->name('post_poste_town_data_table_route');
    });

    // Admin Golf Management
    Route::prefix('golf')->group(function() {
        Route::get('/', 'GolfController@index')->name('get_golf_index_ad_route');
        Route::get('/add', 'GolfController@getUpdate')->name('get_golf_add_ad_route');
        Route::post('/add', 'GolfController@postUpdate')->name('post_golf_add_ad_route');
        Route::get('/edit/{id}', 'GolfController@getUpdate')->name('get_golf_edit_ad_route');
        Route::post('/edit/{id}', 'GolfController@postUpdate')->name('post_golf_edit_ad_route');
        Route::post('/delete', 'GolfController@postDelete')->name('post_golf_delete_ad_route');

        Route::post('/upload-image', 'GolfController@postUploadImage')->name('post_golf_upload_image_ad_route');
        Route::post('/delete-image', 'GolfController@postDeleteImage')->name('post_golf_delete_image_ad_route');

        Route::post('/change-status', 'GolfController@postChangeStatus')->name('post_golf_change_status_ad_route');

        Route::get('/preview/{article}', 'GolfController@getPreview')->name('get_golf_preview_ad_route');
        Route::post('/load-table-data', 'GolfController@loadTableData');
    });

    // Admin Golf Shop Management
    Route::prefix('golf-shop')->group(function() {
        Route::get('/', 'GolfController@golfShopIndex')->name('get_golf_shop_index_ad_route');
        Route::get('/add', 'GolfController@getShopUpdate')->name('get_golf_shop_add_ad_route');
        Route::post('/add', 'GolfController@postShopUpdate')->name('post_golf_shop_add_ad_route');
        Route::get('/edit/{id}', 'GolfController@getShopUpdate')->name('get_golf_shop_edit_ad_route');
        Route::post('/edit/{id}', 'GolfController@postShopUpdate')->name('post_golf_shop_edit_ad_route');
        Route::post('/delete', 'GolfController@postShopDelete')->name('post_golf_shop_delete_ad_route');
        Route::get('/preview/{article}', 'GolfController@getPreview')->name('get_golf_preview_ad_route');
    });


    // Admin Movie Management
    Route::prefix('movie')->group(function() {
        Route::get('/', 'CinemaController@index')->name('get_movie_index_ad_route');
        Route::get('/add', 'CinemaController@getUpdate')->name('get_movie_add_ad_route');
        Route::post('/add', 'CinemaController@postUpdate')->name('post_movie_add_ad_route');
        Route::get('/edit/{id}', 'CinemaController@getUpdate')->name('get_movie_edit_ad_route');
        Route::post('/edit/{id}', 'CinemaController@postUpdate')->name('post_movie_edit_ad_route');

        Route::post('change-status', 'CinemaController@postChangeMovieStatus')->name('post_movie_change_status_ad_route');
        Route::post('delete', 'CinemaController@postDeleteMovie')->name('post_movie_delete_ad_route');
    });

    // Admin Theater Management
    Route::prefix('theater')->group(function() {
        Route::get('/', 'CinemaController@getTheaterList')->name('get_theater_index_ad_route');
        Route::get('/add', 'CinemaController@getTheaterUpdate')->name('get_theater_add_ad_route');
        Route::post('/add', 'CinemaController@postTheaterUpdate')->name('post_theater_add_ad_route');
        Route::get('/edit/{id}', 'CinemaController@getTheaterUpdate')->name('get_theater_edit_ad_route');
        Route::post('/edit/{id}', 'CinemaController@postTheaterUpdate')->name('post_theater_edit_ad_route');

        Route::get('/ajax-add-position', 'CinemaController@ajaxAddMorePosition')->name('get_ajax_theater_add_position_ad_route');
        Route::post('/delete-position', 'CinemaController@postDeletePosition')->name('post_ajax_theater_delete_position_ad_route');
        Route::post('/position-delete-view', 'CinemaController@posteDeleteAndGetView')->name('post_ajax_thetaer_delete_position_view_ad_route');
        Route::post('change-status', 'CinemaController@postChangeTheaterStatus')->name('post_change_theater_status_ad_route');
    });

    // Admin Showtime Management
    Route::prefix('movie-show-time')->group(function() {
        Route::get('/', 'CinemaController@getUpdateShowTime')->name('get_showtime_update_ad_route');
        Route::post('/', 'CinemaController@postUpdateShowTime')->name('post_showtime_update_ad_route');

        Route::get('/add-show-time', 'CinemaController@getAjaxAddShowTime')->name('get_ajax_add_showtime_ad_route');
        Route::get('/get-position', 'CinemaController@getAjaxPositionFromBranch')->name('get_ajax_get_position_ad_route');
        Route::get('/get-showtime-list', 'CinemaController@getAjaxShowtimeList')->name('get_ajax_showtime_list_ad_route');

        Route::post('/delete', 'CinemaController@postDeleteShowtime')->name('post_delete_showtime_ad_route');
    });

    // Admin Classified Management
    // Ad Personal-Trading Management
    Route::prefix('personal-trading')->group(function() {
        Route::get('/', 'PersonalTradingController@index')->name('get_personal_trading_index_ad_route');
        Route::get('/add', 'PersonalTradingController@getAdd')->name('get_personal_trading_add_ad_route');
        Route::post('/change-status', 'PersonalTradingController@changeStatus')->name('post_job_searchings_change_status_ad_route');
        Route::post('/delete', 'PersonalTradingController@postDelete')->name('post_personal_trading_deleted_ad_route');
        Route::post('/load-table-data', 'PersonalTradingController@loadTableData');
    });

    // Admin Job-searching Management
    Route::prefix('job-searching')->group(function() {
        Route::get('/', 'JobSearchingController@index')->name('get_job_searchings_index_ad_route');
        Route::post('/change-status', 'JobSearchingController@changeStatus')->name('post_job_searchings_change_status_ad_route');
        Route::post('/delete', 'JobSearchingController@postDelete')->name('post_job_searchings_deleted_ad_route');
        Route::post('/load-table-data', 'JobSearchingController@loadTableData');
    });

    // Admin Real-Estate Management
    Route::prefix('real-estate')->group(function() {
        Route::get('/', 'RealEstateController@index')->name('get_real_estate_index_ad_route');
        Route::post('/change-status', 'RealEstateController@changeStatus')->name('post_real_estate_change_status_ad_route');
        Route::post('/delete', 'RealEstateController@postDelete')->name('post_real_estate_deleted_ad_route');
        Route::post('/load-table-data', 'RealEstateController@loadTableData');
    });

    // Admin Bullboard Management
    Route::prefix('bull-board')->group(function() {
        Route::get('/', 'BullBoardController@index')->name('get_bull_board_index_ad_route');
        Route::post('/change-status', 'BullBoardController@changeStatus')->name('post_bull_board_change_status_ad_route');
        Route::post('/delete', 'BullBoardController@postDelete')->name('post_bull_board_deleted_ad_route');
        Route::post('/load-table-data', 'BullBoardController@loadTableData');
    });

    // Admin Customer Management
    Route::prefix('customer')->group(function() {
        Route::get('/', 'CustomerController@index')->name('get_customer_index_ad_route');
        Route::get('/add', 'CustomerController@getUpdate')->name('get_customer_add_ad_route');
        Route::post('/add', 'CustomerController@postUpdate')->name('post_customer_add_ad_route');
        Route::get('/edit/{id}', 'CustomerController@getUpdate')->name('get_customer_edit_ad_route');
        Route::post('/edit/{id}', 'CustomerController@postUpdate')->name('post_customer_edit_ad_route');
        Route::post('/change-status', 'CustomerController@changeStatus')->name('post_customer_change_status_ad_route');

        Route::post('/ajax-add-customer', 'CustomerController@ajaxAddCustomer')->name('post_customer_ajax_add_ad_route');
        Route::post('/load-table-data', 'CustomerController@loadTableData')->name('post_customer_load_table_data_route');
    });

    Route::middleware('auth.admin')->group(function() {
        // Admin Category Management
        Route::prefix('category')->group(function() {
            Route::get('/', 'CategoryController@index')->name('get_category_index_ad_route');
            Route::get('/add', 'CategoryController@getUpdate')->name('get_category_add_ad_route');
            Route::post('/add', 'CategoryController@postUpdate')->name('post_category_add_ad_route');
            Route::get('/edit/{id}', 'CategoryController@getUpdate')->name('get_category_edit_ad_route');
            Route::post('/edit/{id}', 'CategoryController@postUpdate')->name('post_category_edit_ad_route');
            Route::post('/delete', 'CategoryController@postDelete')->name('post_category_delete_ad_route');

            Route::post('change-status', 'CategoryController@changeStatus')->name('post_category_change_status_route');

            Route::post('/load-data-table', 'CategoryController@loadDataTable');
        });

        // Admin Sub Category Management
        Route::prefix('sub-category')->group(function() {
            Route::get('/', 'SubCategoryController@index')->name('get_sub_category_index_ad_route');

            Route::get('/add', 'SubCategoryController@getUpdate')->name('get_sub_category_add_ad_route');
            Route::post('/add', 'SubCategoryController@postUpdate')->name('post_sub_category_add_ad_route');
            Route::get('/edit/{id}', 'SubCategoryController@getUpdate')->name('get_sub_category_edit_ad_route');
            Route::post('/edit/{id}', 'SubCategoryController@postUpdate')->name('post_sub_category_edit_ad_route');
            Route::post('/delete', 'SubCategoryController@postDelete')->name('post_sub_category_delete_ad_route');

            Route::post('change-status', 'SubCategoryController@changeStatus')->name('post_sub_category_change_status_route');
            Route::get('/get-parent-from-tag', 'SubCategoryController@getParentFromNewsType');

            Route::post('/load-data-table', 'SubCategoryController@loadDataTable');
        });

        // Admin Param Management
        Route::prefix('param')->group(function() {
            Route::get('/', 'ParamController@index')->name('get_param_index_ad_route');
            Route::get('/add', 'ParamController@getAdd')->name('get_param_add_ad_route');
            Route::post('/add', 'ParamController@postAdd')->name('post_param_add_ad_route');
            Route::get('/delete', 'ParamController@getDelete')->name('get_param_delete_ad_route');
            Route::post('/delete', 'ParamController@postDelete')->name('post_param_delete_ad_route');

            Route::post('/change-show-on-gallery', 'ParamController@changeShowOnGallery')->name('post_param_change_show_gallery_route');
            Route::post('/load-table-data', 'ParamController@loadTableData');
        });

        // Admin City Management
        Route::prefix('city')->group(function() {
            Route::get('/', 'CityController@index')->name('get_city_index_ad_route');
            Route::get('/add', 'CityController@getAdd')->name('get_city_add_ad_route');
            Route::post('/add', 'CityController@postAdd')->name('post_city_add_ad_route');
            Route::post('/change-status', 'CityController@posteChangeStatus')->name('post_city_change_status_ad_route');
            Route::post('/load-table-data', 'CityController@loadTableData');
        });

        // Admin District Management
        Route::prefix('district')->group(function() {
            Route::get('/', 'DistrictController@index')->name('get_district_index_ad_route');
            Route::get('/add', 'DistrictController@getAdd')->name('get_district_add_ad_route');
            Route::post('/add', 'DistrictController@postAdd')->name('post_district_add_ad_route');

            Route::get('/get-district-from-city/{city_id}', 'DistrictController@getDistrictFromCity');
        });

        // Admin User Management
        Route::prefix('user')->group(function() {
            Route::get('/', 'UserController@index')->name('get_user_index_ad_route');

            Route::post('/load-table-data', 'UserController@loadTableData')->name('post_user_load_table_data_route');
            Route::post('/change-letter', 'UserController@changeLetter')->name('post_user_change_letter_ad_route');
            Route::post('/change-role', 'UserController@changePermission')->name('post_user_change_permission_ad_route');
            Route::post('/change-status', 'UserController@changeStatus')->name('post_user_change_status_ad_route');
        });

        // Admin Setting Management
        Route::prefix('setting')->group(function() {
            Route::get('/', 'SettingController@index')->name('get_setting_index_ad_route');

            Route::get('/add', 'SettingController@getUpdate')->name('get_setting_add_ad_route');
            Route::post('/add', 'SettingController@postUpdate')->name('post_setting_add_ad_route');
            Route::get('/edit/{id}', 'SettingController@getUpdate')->name('get_setting_edit_ad_route');
            Route::post('/edit/{id}', 'SettingController@postUpdate')->name('post_setting_edit_ad_route');
            Route::post('/delete', 'SettingController@postDelete')->name('post_setting_delete_ad_route');
            Route::post('/load-table-data', 'SettingController@loadTableData')->name('post_setting_load_table_data_route');
        });

        Route::prefix('seo-meta')->group(function() {
            Route::get('/', 'MetaController@index')->name('get_seo_meta_index_ad_route');

            Route::get('/add', 'MetaController@getUpdate')->name('get_seo_meta_add_ad_route');
            Route::post('/add', 'MetaController@postUpdate')->name('post_seo_meta_add_ad_route');
            Route::get('/edit/{id}', 'MetaController@getUpdate')->name('get_seo_meta_edit_ad_route');
            Route::post('/edit/{id}', 'MetaController@postUpdate')->name('post_seo_meta_edit_ad_route');

            Route::post('/delete', 'MetaController@postDelete');

            Route::post('load-data-table', 'MetaController@loadDataTable');
        });
    });
});
