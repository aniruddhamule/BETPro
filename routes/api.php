<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UiController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::post('/forgot/send', [AuthController::class, 'sendResetPassMail']);
Route::post('/reset', [AuthController::class, 'resetPasswordForm']);
Route::post('/reset/password', [AuthController::class, 'resetPassword']);

//front end section
Route::namespace('Api')->group(function () {
    Route::get('index', 'UiController@index');

    Route::get('all-matches', 'UiController@allEvents');
    Route::get('category/{slug}', 'UiController@categories');
    Route::get('tournament/{cat_slug}/{slug}', 'UiController@tournament');
    Route::get('finished-match', 'UiController@allFinished');
    Route::get('cancelled-match', 'UiController@allCancelled');
    Route::get('open-playing-match', 'UiController@allLiveMatch');
    Route::get('up-coming-match', 'UiController@allUpComMatch');

    Route::get('about', 'UiController@aboutIndex');

    Route::get('contact', 'UiController@contactIndex');
    Route::post('contact', 'UiController@contactSend');

    Route::get('news', 'UiController@newsIndex');
    Route::get('news-details/{slug?}/{id?}', 'UiController@newsDetails');
    Route::get('/search', 'UiController@search');

    Route::get('policy/{slug?}', 'UiController@policyIndex');

    Route::post('subscriber', 'UiController@subscriberStore');

    Route::get('/authorization', 'UiController@authorization');
    Route::post('/sendemailver', 'UiController@sendemailver');
    Route::post('/emailverify', 'UiController@emailverify');
    Route::post('/g2fa-verify', 'UiController@verify2fa');
});


Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::post('home', [HomeController::class, 'home']);

    Route::get('bet-log', 'HomeController@myPredictindex');

    Route::post('prediction', 'HomeController@prediction');

    Route::get('profile-setting', 'HomeController@profileIndex');
    Route::post('profile-setting', 'HomeController@profileUpdate');

    Route::get('change-password', 'HomeController@passwordIndex');
    Route::post('password', 'HomeController@passwordUpdate');

    Route::get('deposit', 'DepositController@index');
    Route::post('deposit-confirm', 'DepositController@depositPayNow');
    Route::get('deposit-log', 'DepositController@depositLog');
    Route::post('deposit-callback', 'DepositController@userDataUpdate');

    // Route::get('referral/{level?}', 'HomeController@myRef');


    Route::get('ticket', 'TicketController@userSupportIndex');
    Route::get('ticket/new', 'TicketController@ticketCreate');
    Route::post('store/ticket', 'TicketController@ticketStore');
    Route::get('comment/close/{support}', 'TicketController@ticketClose');
    Route::get('support/reply/{support}', 'TicketController@ticketReply');
    Route::post('support/store/{support}', 'TicketController@ticketReplyStore');

    Route::get('withdraw', 'HomeController@withdrawIndex');
    Route::post('withdraw/confirm', 'HomeController@storeWithdraw');
    Route::get('withdraw-log', 'HomeController@withdrawLog');

    Route::get('transaction-log', 'HomeController@transactionLog');
    Route::get('search-transaction/', 'HomeController@searchTrans');

    Route::get('/twofactor', 'HomeController@twoFactorIndex');
    Route::post('/g2fa-create', 'HomeController@create2fa');
    Route::post('/g2fa-disable', 'HomeController@disable2fa');

    // Route::get('/logout', 'AuthController@logout');
});
