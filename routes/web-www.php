<?php
Route::namespace('Page')->group(function() {

    /* Authenticate routes */
    Route::get('/login', 'AccountController@getLogin')->name('login');
    Route::post('/login', 'AccountController@postLogin')->name('post_login');
    Route::get('/register', 'AccountController@getRegister')->name('register');
    Route::post('/register', 'AccountController@postRegister')->name('post_register');
    Route::get('/verify', 'AccountController@getVerify')->name('verify');
    Route::post('/verify', 'AccountController@postResend')->name('post_resend');
    Route::get('/active-account/{token}', 'AccountController@getActiveAccount')->name('get_active_account');
    Route::post('/logout', 'AccountController@postLogout')->name('logout');
    /* End Authenticate routes */

    // Redirect/Campaign route
    Route::get('/redirect', 'HomeController@redirect')->name('redirect_route');

    // Poste Route
    Route::get('advertisement', 'HomeController@advertisement')->name('get_advertisement_route');

    // Contact route
    Route::get('/contact', 'HomeController@getContact')->name('get_contact_route');
    Route::post('/contact', 'HomeController@postContact')->name('post_contact_route');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/term-of-use', 'HomeController@termOfUse')->name('get_term_of_use_route');

    // Dailyinfo Routes
    Route::prefix('dailyinfo')->group(function() {
        Route::get('/', 'DailyinfoController@index')->name('get_dailyinfo_index_route');
        Route::get('/category/{category}', 'DailyinfoController@category')->name('get_dailyinfo_category_route');
        Route::get('/{detail}', 'DailyinfoController@detail')->name('get_dailyinfo_detail_route');
    });

    // Lifetip Routes
    Route::prefix('lifetip')->group(function() {
        Route::get('/', 'LifetipController@index')->name('get_lifetip_index_route');
        Route::get('/category/{category}', 'LifetipController@category')->name('get_lifetip_category_route');
        Route::get('/{detail}', 'LifetipController@detail')->name('get_lifetip_detail_route');
    });

    // Golf Routes
    Route::prefix('golf')->group(function() {
        Route::get('/', 'GolfController@index')->name('get_golf_index_route');
        Route::get('/{detail}', 'GolfController@detail')->name('get_golf_detail_route');
    });

    Route::prefix('golf-shop')->group(function() {
        Route::get('/{detail}', 'GolfController@shopDetail')->name('get_golf_shop_detail_route');
    });

    // Business
    Route::prefix('business')->group(function() {

        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new', 'BusinessController@getUpdate')->name('get_business_new_route');
            Route::get('/edit/{business}', 'BusinessController@getUpdate')->name('get_business_edit_route');
            Route::post('/edit/{business}', 'BusinessController@postUpdate')->name('post_business_edit_route');

            Route::post('/save-basic-info', 'BusinessController@postUpdate')->name('post_business_save_basic_info_route');
            Route::post('/save-service-info', 'BusinessController@postSaveService')->name('post_business_save_services_route');
            Route::post('/save-related-business', 'BusinessController@postSaveRelated')->name('post_business_save_related_route');
            Route::post('/save-primary-address', 'BusinessController@postSavePrimaryAddress')->name('post_business_save_primary_map_route');
            Route::post('/save-more-map', 'BusinessController@postSaveMoreMap')->name('post_business_save_more_map_route');

            Route::post('/delete-map', 'BusinessController@postDeleteMap')->name('post_business_delete_map_route');
            Route::post('/delete-relate', 'BusinessController@posteDeleteRelate')->name('post_business_delete_relate_route');
            Route::post('/delete-pdf', 'BusinessController@postDeletePDF')->name('post_business_delete_pdf_route');
            Route::post('/delete-service', 'BusinessController@postDeleteService')->name('post_business_delete_service_route');

            Route::post('/add-gallery-image', 'BusinessController@postUploadGallery')->name('post_ajax_upload_image_gallery');
            Route::post('/upload-pdf-menu', 'BusinessController@postUploadPDFFile')->name('post_ajax_upload_image_gallery');
        });

        Route::get('/', 'BusinessController@index')->name('get_business_index_route');
        Route::get('/category/{category}', 'BusinessController@category')->name('get_business_category_route');
        Route::post('/send-feedback', 'BusinessController@postSaveFeedback')->name('post_business_feedback_route');
        Route::get('/load-more-images', 'BusinessController@loadMoreImages')->name('get_load_more_images_route');
        Route::get('/{detail}', 'BusinessController@detail')->name('get_business_detail_route');
    });

    // Poste Town
    Route::prefix('town')->group(function() {
        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new', 'TownController@getNew')->name('get_town_new_route');
            Route::post('/new', 'TownController@postNew')->name('post_town_new_route');
            Route::get('/edit/{article}', 'TownController@getEdit')->name('get_town_edit_route');

            Route::post('/add-basic-info', 'TownController@postUpdateBasicInfo')->name('post_town_ajax_update_basic_info');
            Route::post('/add-features-info', 'TownController@postUpdateFeaturesInfo')->name('post_town_ajax_update_features_info');
            Route::post('/add-image-gallery', 'TownController@postImageGallery')->name('post_town_ajax_add-image-gallery');
            Route::post('/save-gallery', 'TownController@postSaveGallery')->name('post_town_ajax_save_gallery');
            Route::post('/save-menu', 'TownController@postUpdateMenu')->name('post_town_ajax_save_menu');
            Route::post('/update-menu', 'TownController@postUpdateMenu')->name('post_town_ajax_update_menu');
            Route::post('/upload-pdf-menu', 'TownController@postUploadPDFMenu')->name('post_town_ajax_upload_pdf_menu');
            Route::post('/update-working-time', 'TownController@postUpdateWorkingTime')->name('post_town_ajax_update_working_time');
            Route::post('/update-regular-closing', 'TownController@postUpdateRegularClose')->name('post_town_ajax_update_regular_close');

            Route::post('/delete-gallery', 'TownController@postDeleteGallery')->name('post_town_ajax_delete_gallery');
            Route::post('/delete-food', 'TownController@postDeleteFood')->name('post_town_ajax_delete_food');
            Route::post('/delete-menu', 'TownController@postDeleteMenu')->name('post_town_ajax_delete_menu');
            Route::post('/delete-pdf', 'TownController@postDeletePDF')->name('post_town_ajax_delete_pdf');
            Route::post('/delete-regular-time', 'TownController@postDeleteRegularTime')->name('post_town_ajax_delete_regular_time');

        });
        Route::get('/', 'TownController@index')->name('get_town_index_route');
        Route::get('/category/{category}', 'TownController@category')->name('get_town_category_route');
        Route::get('/tag/{tag}', 'TownController@tag')->name('get_town_tag_route');
        Route::post('/send-feedback', 'TownController@postSaveFeedback')->name('post_town_feedback_route');

        Route::get('/{detail}', 'TownController@detail')->name('get_town_detail_route');
    });

    // Cinema
    Route::prefix('cinema')->group(function() {
        Route::get('/', 'CinemaController@index')->name('get_cinema_index_route');
    });

    // Personal Trading
    Route::prefix('personal-trading')->group(function() {
        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new-post', 'PersonalTradingController@getUpdate')->name('get_personal_trading_add_route');
            Route::post('/new-post', 'PersonalTradingController@postUpdate')->name('post_personal_trading_add_route');

            Route::get('/edit-post/{article}', 'PersonalTradingController@getUpdate')->name('get_personal_trading_edit_route');
            Route::post('/edit-post/{article}', 'PersonalTradingController@postUpdate')->name('post_personal_trading_edit_route');

            Route::post('/delete', 'PersonalTradingController@postDelete')->name('post_personal_trading_delete_route');

            Route::get('/list', 'PersonalTradingController@getList')->name('get_personal_trading_list_route');
        });

        Route::get('/', 'PersonalTradingController@index')->name('get_personal_trading_index_route');
        Route::get('/type/{type}', 'PersonalTradingController@type')->name('get_personal_trading_type_route');
        Route::get('/category/{category}', 'PersonalTradingController@category')->name('get_personal_trading_category_route');
        Route::post('/contact/{article_id}', 'PersonalTradingController@contact')->name('get_personal_trading_contact_route');
        Route::get('/{article}', 'PersonalTradingController@detail')->name('get_personal_trading_detail_route');
    });

    // Realestate
    Route::prefix('real-estate')->group(function() {
        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new-post', 'RealEstateController@getUpdate')->name('get_real_estate_add_route');
            Route::post('/new-post', 'RealEstateController@postUpdate')->name('post_real_estate_add_route');

            Route::get('/edit-post/{article}', 'RealEstateController@getUpdate')->name('get_real_estate_edit_route');
            Route::post('/edit-post/{article}', 'RealEstateController@postUpdate')->name('post_real_estate_edit_route');

            Route::post('/delete', 'RealEstateController@postDelete')->name('post_real_estate_delete_route');

            Route::get('/list', 'RealEstateController@getList')->name('get_real_estate_list_route');
        });

        Route::get('/', 'RealEstateController@index')->name('get_real_estate_index_route');
        Route::get('/type/{type}', 'RealEstateController@type')->name('get_real_estate_type_route');
        Route::get('/category/{category}', 'RealEstateController@category')->name('get_real_estate_category_route');
        Route::get('/bedroom/{bedroom}', 'RealEstateController@bedroom')->name('get_real_estate_bedroom_route');
        Route::get('/price/{price}', 'RealEstateController@price')->name('get_real_estate_price_route');
        Route::post('/contact/{article_id}', 'RealEstateController@contact')->name('get_real_estate_contact_route');
        Route::get('/{article}', 'RealEstateController@detail')->name('get_real_estate_detail_route');
    });

    // JobSearching
    Route::prefix('job-searching')->group(function() {
        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new-post', 'JobSearchingController@getUpdate')->name('get_job_searching_add_route');
            Route::post('/new-post', 'JobSearchingController@postUpdate')->name('post_job_searching_add_route');

            Route::get('/edit-post/{article}', 'JobSearchingController@getUpdate')->name('get_job_searching_edit_route');
            Route::post('/edit-post/{article}', 'JobSearchingController@postUpdate')->name('post_job_searching_edit_route');

            Route::post('/delete', 'JobSearchingController@postDelete')->name('post_job_searching_delete_route');

            Route::get('/list', 'JobSearchingController@getList')->name('get_job_searching_list_route');
        });

        Route::get('/', 'JobSearchingController@index')->name('get_jobsearching_index_route');
        Route::get('/type/{type}', 'JobSearchingController@type')->name('get_jobsearching_type_route');
        Route::get('/category/{category}', 'JobSearchingController@category')->name('get_jobsearching_category_route');
        Route::get('/nationality/{national}', 'JobSearchingController@nationality')->name('get_jobsearching_nationality_route');
        Route::post('/contact/{article_id}', 'JobSearchingController@contact')->name('get_jobsearching_contact_route');
        Route::get('/{article}', 'JobSearchingController@detail')->name('get_jobsearching_detail_route');
    });

    // Bullboard
    Route::prefix('bullboard')->group(function() {
        Route::middleware(['auth', 'verified'])->group(function() {
            Route::get('/new-post', 'BullBoardController@getUpdate')->name('get_bullboard_add_route');
            Route::post('/new-post', 'BullBoardController@postUpdate')->name('post_bullboard_add_route');

            Route::get('/edit-post/{article}', 'BullBoardController@getUpdate')->name('get_bullboard_edit_route');
            Route::post('/edit-post/{article}', 'BullBoardController@postUpdate')->name('post_bullboard_edit_route');

            Route::post('/delete', 'BullBoardController@postDelete')->name('post_bullboard_delete_route');

            Route::get('/list', 'BullBoardController@getList')->name('get_bullboard_list_route');
        });

        Route::get('/', 'BullBoardController@index')->name('get_bullboard_index_route');
        Route::get('/category/{category}', 'BullBoardController@category')->name('get_bullboard_category_route');
        Route::post('/contact/{article_id}', 'BullBoardController@contact')->name('get_bullboard_contact_route');
        Route::get('/{article}', 'BullBoardController@detail')->name('get_bullboard_detail_route');
    });

    // Ajax URL
    Route::prefix('ajax')->group(function() {
        // Neu can validate gia tri nhap tu ditrict, lay url tu admin
        // Nguoc lai su dung admin nay.
        Route::get('/get-district-from-city/{city_id}','HomeController@getDistrictFromCity');
    });

    // Customer Route
    Route::get('/{seg1?}/{seg2?}/{seg3?}', 'CustomerPageController@getCustomer')->name('get_customer_page');
});
