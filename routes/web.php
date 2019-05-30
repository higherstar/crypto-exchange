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
    return view('comingsoon');
});

Route::prefix('mc')->group(function()
{
   route::prefix('launch')->group(function()
   {
       // when a user subscribes to our launch list
       route::get('subscribed', function(){
           // do something
           return view('mailchimp.launch.subscribed');
       });

   });
});


//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('mvp-alpha')->group(function(){

    Auth::routes();

    Route::get('/', function(){
        return view('home');
    })->name('home');

    Route::get('signup', function(){ return Redirect::route('register');});
    Route::get('verification', 'VerificationsController@index')->name('verifications.index');
    Route::post('verification', 'VerificationsController@store')->name('verifications.store');
    Route::post('verification/mobile', 'MobileVerificationController@send')->name('verifications.mobile.send');
    Route::put('verification/mobile', 'MobileVerificationController@verify')->name('verifications.mobile.verify');

    Route::get('orders', 'OrdersController@fetchStore')->name('orders.fetchStore');
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    Route::get('orders/history', 'OrdersController@index')->name('orders.index');
    Route::get('orders/history/data', 'OrdersController@orderHistory')->name('orders.index.data');

    Route::post('payments/store', 'PaymentsController@store')->name('payments.store');
    Route::get('payments/result', 'PaymentsController@result')->name('payments.result');
    Route::get('payments/response', 'PaymentsController@response')->name('payments.response');
    Route::get('payments/receipt', 'PaymentsController@receipt')->name('payments.receipt');
});