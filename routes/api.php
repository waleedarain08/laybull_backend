<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/userProducts', 'Api\ProductsApiController@userProducts');
Route::middleware('auth:api')->resource('wishlist', 'Api\wishListApiController');


Route::middleware('auth:api')->get('/userId', function (Request $request) {
    return $request->user()->id;
});

Route::group(['namespace'=> 'Api'],function (){

    Route::post('signup','AuthenticateController@signup');
    Route::post('login','AuthenticateController@login');

    Route::middleware('auth:api')->group(function () {

        //Products Routes
        Route::get('getProducts', 'ProductApiController@getProducts');
        Route::get('getSingleProduct', 'ProductApiController@getSingleProduct');
        Route::post('addProduct', 'ProductApiController@store');
        Route::post('editProduct', 'ProductApiController@update');
        Route::get('categoryWiseProducts', 'ProductApiController@categoryWiseProduct');

        //Search And Filter Product
        Route::get('popularProducts', 'ProductApiController@popularProducts');
        Route::get('searchProduct', 'ProductApiController@searchProduct');
        Route::get('searchFilterProduct', 'ProductApiController@searchFilterProduct');

        //Product Biding
        Route::post('biding', 'ProductBidController@biding');
        Route::post('bid-counter', 'ProductBidController@bid_counter');
        Route::post('bid-status', 'ProductBidController@bid_status');

        //User Routes
        Route::get('getUser', 'UserController@getUser');

        //Category Routes
        Route::get('allCategories', 'CategoryController@allCategories');
        Route::get('getSingleCategory', 'CategoryController@getSingleCategory');

        //User Follow and Following
        Route::post('follow', 'FollowController@follow');
        Route::post('unfollow', 'FollowController@unfollow');
        Route::get('my-followers', 'FollowController@myFollowers');

        //Offers And Recieved Routes
        Route::get('getSendOffersList', 'OfferController@offers');
        Route::get('getReceivedOffers', 'OfferController@collectOffers');


    });







    Route::get('users','UserController@list');
    Route::get('vendors','UserController@fetchAllVendors');
    Route::post('useredit/{id?}','UserController@useredit');
    Route::get('userstats/{id?}', 'UserController@stats')->name('user.stats');



    Route::post('reservationCheckout','ReservationBookingController@store');

    Route::get('userfoodbooking/inprogressOrders/{id?}','FoodBookingController@inProgressOrders');
    Route::get('userfoodbooking/completedOrders/{id?}','FoodBookingController@completedOrders');

    //InProgress & completeOrders(Api\FoodBookingController) Api for Vendor
    Route::get('userfoodbooking/inprogressOrdersVendor/{id?}','FoodBookingController@inProgressOrdersVendor');
    Route::get('userfoodbooking/completedOrdersVendor/{id?}','FoodBookingController@completedOrdersVendor');



    Route::get('usergrocerybooking/inprogressOrders/{id?}','GroceryBookingController@inProgressOrders');
    Route::get('usergrocerybooking/completedOrders/{id?}','GroceryBookingController@completedOrders');


      //POST For VendorStatus
    Route::post('vendorStatusFood','FoodBookingController@vendorStatus');
    Route::post('vendorStatusGrocery','GroceryBookingController@vendorStatus');
    Route::post('vendorStatusStore','StoreBookingController@vendorStatus');

    Route::get('vendorreservation/{id?}','ReservationController@vendorreservation');

    Route::get('getreservation/{id?}','ReservationController@getreservation');
//  Route::get('getallreservation','ReservationController@getallreservation');

    Route::get('getallreservation','ReservationController@getallreservationdetail');

    Route::get('userreservation/inprogress/{id?}', 'ReservationBookingController@inProgressReservation');
    Route::get('userreservation/completed/{id?}', 'ReservationBookingController@completedReservation');


    Route::get('categories/{id}','CategoryController@show');
    Route::get('categories','CategoryController@index');
    Route::get('brands','CategoryController@brands');
//    Route::resource('categories', 'CategoryApiController');

    Route::middleware('api')->get('getWishlist', 'wishListApiController@getWishlist');
    Route::middleware('api')->post('bidProduct', 'BidController@saveBid');
    Route::middleware('api')->get('receivedOffers', 'BidController@receivedOffers');
    Route::post('payment', 'BidController@payment');
    Route::post('filter', 'ProductApiController@filter');
    Route::post('testPayment', 'ProductApiController@testPayment');



});



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//products api
Route::resource('allproducts', 'App\Http\Controllers\ProductsApiController');

//Route::post('searchProduct', 'ProductsApiController@singleProduct');
//deals of the day api
Route::get('dealsoftheday', 'ProductsApiController@randomProducts');

//banner's api
Route::resource('banners', 'BannerApiController');

//categories api
//Route::resource('categories', 'Api\CategoryApiController');
//random 3 categories api
Route::get('randomCategories', 'CategoryApiController@randomCategories');

//category wise products api
Route::get('categoryWiseProduct', 'ProductsApiController@categoryWise');

//users api for native
Route::post('getCustomer', 'CustomerApiController@getCustomer');
Route::resource('createCustomer', 'CustomerApiController');
Route::post('createCustomerFirebase', 'CustomerApiController@firebaseRegister');
Route::post('loginForm', 'CustomerApiController@loginForm');
Route::post('loginFirebase', 'CustomerApiController@loginFirebase');

//vendors api
Route::post('registerVendor', 'VendorsApiController@register');
Route::post('loginVendor', 'VendorsApiController@login');
Route::post('editVendor/{id}', 'VendorsApiController@editVendor');
Route::resource('vendor', 'VendorsApiController');

//orders api
Route::get('getOrder/{cust?}', 'OrdersApiController@getOrder');
Route::get('getDeliveryCharges', 'OrdersApiController@getDeliveryCharges');
Route::resource('createOrder', 'OrdersApiController');
// farhan
Route::resource('shipment', 'ShipmentController');
Route::post('payment-process', 'ShipmentController@payment');

Route::middleware('auth:api')->get('user_profile', 'Api\UserController@get_profile');
Route::middleware('auth:api')->get('list-of-sold-product', 'ShipmentController@list_of_sold_product');
Route::get('list-of-countries', 'CountryController@list_of_sold_countries');
Route::post('place_order_aramex', 'ShipmentController@placeOrder');
Route::post('verify_coupon', 'DiscountController@verify_coupon');

Route::post('seller_account_details', 'Api\UserController@post_seller_account_details');

// end
