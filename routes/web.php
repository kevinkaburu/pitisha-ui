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

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/paypal/payment/verify/{orderID}', 'HomeController@verify_order_id');



Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');


Route::get('/dashboard', 'HomeController@index')->middleware('auth');

Route::group([
    'middleware' => [
        'auth',
        'verified',
    ],
], function() {

    Route::get('/deposit', 'DepositController@index');
    Route::post('/deposit/mpesa', 'DepositController@deposit_mpesa');


    Route::get('/withdraw', 'WithdrawalController@index');
    Route::get('/withdraw/paypal/mobile', 'WithdrawalController@from_paypal_to_mobile');
    Route::get('/withdraw/paypal/bank', 'WithdrawalController@from_paypal_to_bank');
    Route::get('/withdraw/paypal/mobile/verify/{orderID}', 'WithdrawalController@verify_paypal_mobile_withdraw');
    Route::get('/withdraw/paypal/bank/verify/{orderID}', 'WithdrawalController@verify_paypal_bank_withdraw');

    Route::post('/withdraw/mobile', 'WithdrawalController@mobile_withdrawal');
    Route::post('/withdraw/bank', 'WithdrawalController@bank_withdrawal');

    Route::get('/beneficiaries', 'BeneficiaryController@index');
    Route::post('/beneficiaries/add', 'BeneficiaryController@add_beneficiary');


    Route::get('/user/sms/send_otp', 'SettingsController@send_otp');
    Route::post('/user/sms/verify_otp', 'SettingsController@verify_otp');
    Route::post('/user/accounts/add', 'SettingsController@add_account');
    Route::post('/user/identity/add', 'SettingsController@add_identity');


//    Route::get('/send', 'SendMoneyController@index');


    Route::get('/transactions', 'TransactionsController@index');


    Route::get('/settings', 'SettingsController@index');


    Route::get('/disputes', 'DisputesController@index');


    Route::get('/help', 'HelpController@index');
});
