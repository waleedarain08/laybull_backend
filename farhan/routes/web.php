<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'PageController@upgrade']);

		Route::resource('foodcategory','FoodCategoryController');
		Route::resource('food','FoodController');
		//Foodproduct Reviews
		Route::get('foodProductReview','FoodController@reivew')->name('foodProductReview');
		//Foodproduct Reviews
		Route::get('foodVendorReview','FoodController@vendorreivew')->name('foodVendorReview');

		Route::resource('grocerycategory','GroceryCategoryController');
		Route::resource('groceryproduct','GroceryProductController');
		//GroceryProductController Reviews
		Route::get('groceryProductReview','GroceryProductController@reivew')->name('groceryProductReview');
		//GroceryProductController Reviews
		Route::get('groceryVendorReview','GroceryProductController@vendorreivew')->name('groceryVendorReview');

		Route::resource('storecategory','StoreCategoryController');
		Route::resource('storeproduct','StoreProductController');
		//StoreProductController Reviews
		Route::get('storeProductReviews','StoreProductController@reivew')->name('storeProductReviews');
		//StoreProductController Reviews
		Route::get('storeVendorReviews','StoreProductController@vendorreivew')->name('storeVendorReviews');

		Route::resource('hotel','HotelController');
		Route::resource('showroom','ShowRoomController');
		Route::resource('cars','CarController');
		//Booking
		Route::resource('foodbooking','FoodBookingController');
		Route::resource('grocerybooking','GroceryBookingController');
		Route::resource('storebooking','StoreBookingController');
		Route::resource('reservation','ReservationController');
		Route::get('fooddetails','FoodBookingController@fooddetails')->name('fooddetails');

// 					Route::resource('grocerybooking','GroceryBookingController');
// 		Route::get('grocerydetails','GroceryBookingController@grocerydetails')->name('grocerydetails');

		//Hotel Reviews
		Route::get('review','HotelController@reviews')->name('review');
		//ShowRoom Reviews
		Route::get('showroomreview','ShowRoomController@review')->name('showroomreview');
		//Car Reviews
		Route::get('carreview','CarController@review')->name('carreview');

		//User Status Updated Route
		Route::get('updateuserstatus/{id?}','UserController@userstatus')->name('updateuserstatus');

		//Food Status Update Route
		Route::get('updatefoodstatus/{id?}','FoodController@updatefoodstatus')->name('updatefoodstatus');
		//GroceryProduct Status Update Route
		Route::get('updategrocerystatus/{id?}','GroceryProductController@updategrocerystatus')->name('updategrocerystatus');
		//StoreProduct Status Update Route
		Route::get('updatestoreproductstatus/{id?}','StoreProductController@updatestoreproductstatus')->name('updatestoreproductstatus');
		//Hotel Status Update Route
		Route::get('hotelstatusupdate/{id?}','HotelController@hotelstatusupdate')->name('hotelstatusupdate');
		//Showroom Status Update Route
		Route::get('showroomstatus/{id?}','ShowRoomController@showroomstatus')->name('showroomstatus');
		//Cars Status Update Route
		Route::get('statusupdatecars/{id?}','CarController@statusupdatecars')->name('statusupdatecars');

		Route::post('status','FoodBookingController@status')->name('status');

		Route::get('apihotel',[App\Http\Controllers\Api\HotelController::class, 'secondlist'])->name('apihotel');


		Route::post('postroute',[App\Http\Controllers\Api\FoodBookingController::class,'store'])->name('postroute');

        Route::resource('categories', 'CategoryController');

     //brands
    Route::resource('brands', 'BrandController');
    //Products
    Route::resource('products', 'ProductController');

    Route::get('user/block/{id}','UserController@block_user')->name('user.block');
    Route::get('product/approve/{id}','ProductController@approve')->name('products.approve');
    Route::post('product/reject','ProductController@reject')->name('products.reject');

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

});

Route::group(['middleware' => ['auth']], function () {

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
//    //products
//    Route::get('product/approve/{id}','App\Http\Controllers\ProductsController@approve')->name('products.approve');
//    Route::get('product/reject/{id}','App\Http\Controllers\ProductsController@reject')->name('products.reject');
//    Route::resource('products', 'App\Http\Controllers\ProductsController');
//    // Route::post('productDelete/{$product}', 'App\Http\Controllers\ProductsController@delete');
//    Route::get('productsTable', 'App\Http\Controllers\ProductsController@table');
//

    //categories

//
//    //orders
//    Route::resource('orders', 'App\Http\Controllers\OrderController');
////    Route::post('orders/orderDetails/{id}', 'App\Http\Controllers\OrderController@orderDetails');
//
//    //brands
//    Route::resource('brands', 'App\Http\Controllers\BrandController');
//
//    //sizes
//    Route::resource('sizes', 'App\Http\Controllers\ProductSizeController');
//
//    //image & color
//    Route::resource('images', 'App\Http\Controllers\ProductImageController');
//
//    // Delivery Charges
//    Route::get('/deliverycharges/{id}/delete','App\Http\Controllers\DeliveryChargesController@destroy');
//    Route::resource('deliverycharges', 'App\Http\Controllers\DeliveryChargesController');
//
//    //slider / banner
//    Route::resource('sliders', 'App\Http\Controllers\SliderController',['except'=>['destroy']]);
//
//    //vendors
//    Route::resource('vendors', 'App\Http\Controllers\VendorsController');
//    Route::get('/approve/{id}','App\Http\Controllers\VendorsController@approve')->name('vendors.approve');
//    Route::get('/reject/{id}','App\Http\Controllers\VendorsController@reject')->name('vendors.reject');
//    Route::get('/slider/{id}/delete','App\Http\Controllers\SliderController@destroy');
//
//    //content ie about/help
//    Route::resource('contents', 'App\Http\Controllers\ContentController');

});

Route::get('artisan/{cmd}', function ($cmd) {
    Artisan::call("{$cmd}");
    dd(Artisan::output());
});

