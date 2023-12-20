<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontendController;


Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::group(['prefix' => 'user'], function () {
    Route::get('/register', [FrontendController::class, 'register']);
    Route::post('/register', [FrontendController::class, 'userRegister']);
    Route::get('/login', [FrontendController::class, 'login']);
    Route::get('/login/{type}', [FrontendController::class, 'login'])->name('user_login_checkout');
    Route::post('/login', [FrontendController::class, 'userLogin']);
//    Route::get('/login/checkout', [FrontendController::class, 'userLogin'])->name('user_login_checkout');
    Route::get('/resetPassword', [FrontendController::class, 'resetPassword']);
    Route::post('/resetPassword', [FrontendController::class, 'userResetPassword']);
    Route::get('/org-register', [FrontendController::class, 'orgRegister']);
    Route::post('/org-register', [FrontendController::class, 'organizerRegister']);
});

    Route::get('/all-events', [FrontendController::class, 'allEvents']);
    Route::post('/all-events', [FrontendController::class, 'allEvents']);
    Route::get('/events-category/{id}/{name}', [FrontendController::class, 'categoryEvents']);
    Route::get('/event-type/{type}', [FrontendController::class, 'eventType']);
    Route::get('/event/{id}/{name}', [FrontendController::class, 'eventDetail']);
    Route::get('/organization/{id}/{name}', [FrontendController::class, 'orgDetail']);
    Route::post('/report-event', [FrontendController::class, 'reportEvent']);
    Route::get('/all-category', [FrontendController::class, 'allCategory']);
    Route::get('/all-blogs', [FrontendController::class, 'blogs']);
    Route::get('/blog-detail/{id}/{name}', [FrontendController::class, 'blogDetail']);
    Route::get('/contact', [FrontendController::class, 'contact']);


    Route::POST('/event/service/search', [FrontendController::class, 'eventServiceSearch'])->name('event_service_search');
    Route::POST('/advance/search', [FrontendController::class, 'advanceSearch'])->name('advance_search');
//    Route::POST('/order/place', [CartController::class, 'orderPlace'])->name('order_place');



Route::get('/service/category/details/{id}/{name}', [FrontendController::class, 'serviceCategoryDetails'])->name('service_category_details');
    Route::get('/service/details/model', [FrontendController::class, 'serviceDetails'])->name('service_details_model');
    Route::get('/item/add-into/cart', [CartController::class, 'itemAddedIntoCart'])->name('add_item_to_cart');
    Route::get('/item/update/cart', [CartController::class, 'itemUpdateIntoCart'])->name('cart_update');
    Route::get('/cart/details', [CartController::class, 'cartDetails'])->name('cart_details');
    Route::get('/cart/item/remove/{id}', [CartController::class, 'cartItemRemove'])->name('cart_item_remove');

    Route::get('/online/payment', [CartController::class, 'onlinePayment'])->name('online_payment');
    Route::get('/cms/page/{slug}', [FrontendController::class, 'cmsPage'])->name('cms_page');
    Route::get('/faq-page', [FrontendController::class, 'faqPage'])->name('faq_page');

    Route::get('/tour-cart-details/{id}/{slug}', [CartController::class, 'tourCartDetails'])->name('tour_cart_page');
    Route::POST('/order/place', [CartController::class, 'orderPlace'])->name('order_place');
    Route::POST('/order/place/next', [CartController::class, 'orderPlaceNext'])->name('order_place_next');
    Route::POST('/order-place/billing', [CartController::class, 'orderPlaceBilling'])->name('tour_cart_page_billing');


Route::group(['middleware' =>'appuser'], function () {
        Route::get('/checkout/{id}', [FrontendController::class, 'checkout']);
        Route::post('/createOrder', [FrontendController::class, 'createOrder']);
        Route::get('/user/profile', [FrontendController::class, 'profile']);
        Route::get('/division/wise/district/user', [FrontendController::class, 'getDivisionWiseDistrictDropdown'])->name('get_division_wise_district_user');
        Route::get('/district/wise/upazila/user', [FrontendController::class, 'getDistrictWiseUpazilaDropdown'])->name('get_district_wise_upazila_user');
        Route::get('/category/wise/service/user', [ServiceController::class, 'categoryWiseService'])->name('category_wise_service_user');
        Route::get('/user/billing/info', [FrontendController::class, 'userBillingInfo'])->name('user_billing_info');
        Route::post('/user/billing/update', [FrontendController::class, 'userBillingInfoUpdate'])->name('update_user_billing');
        Route::post('/user/order/billing/update/{id}', [CartController::class, 'userOrderBillingInfoUpdate'])->name('update_order_billing');
        Route::get('/add-favorite/{id}/{type}', [FrontendController::class, 'addFavorite']);
        Route::get('/add-followList/{id}', [FrontendController::class, 'addFollow']);
        Route::post('/add-bio', [FrontendController::class, 'addBio']);
        Route::get('/change-password', [FrontendController::class, 'changePassword']);
        Route::post('/change-password', [FrontendController::class, 'changeUserPassword']);
        Route::post('/upload-profile-image', [FrontendController::class, 'uploadProfileImage']);
        Route::get('/my-tickets', [FrontendController::class, 'userTickets']);
        Route::get('/update_profile', [FrontendController::class, 'update_profile']);
        Route::post('/update_user_profile', [FrontendController::class, 'update_user_profile']);
        Route::get('/getOrder/{id}', [FrontendController::class, 'getOrder']);
        Route::post('/add-review', [FrontendController::class, 'addReview']);
        Route::get('/web/create-payment/{id}', [FrontendController::class, 'makePayment']);
        Route::post('/web/payment/{id}', [FrontendController::class, 'initialize'])->name('frontendPay');
        Route::get('/web/rave/callback/{id}', [FrontendController::class, 'callback'])->name('frontendCallback');

    });

?>
