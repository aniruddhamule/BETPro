<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('clean',function(){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return 'Cache has been cleared'; 
});

Route::get('/cron', 'UiController@cronAction');
Route::get('/bet-api-cat-event', 'UiController@apiCatEvent')->name('bet.api.cat.event');
Route::get('/bet-api-event-match/{event_key}', 'UiController@apiEventMatch')->name('bet.api.event.match');

Auth::routes();

Route::get('/', 'UiController@index')->name('frontend.index');
Route::get('about', 'UiController@aboutIndex')->name('frontend.about.index');
Route::get('contact', 'UiController@contactIndex')->name('frontend.contact.index');
Route::post('contact', 'UiController@contactSend')->name('frontend.contact.send');
Route::get('news', 'UiController@newsIndex')->name('frontend.news.index');
Route::get('news-details/{slug}/{id}', 'UiController@newsDetails')->name('frontend.newsDetails');
Route::get('policy/{slug}', 'UiController@policyIndex')->name('frontend.policyIndex');
Route::get('all-events', 'UiController@allEvents')->name('frontend.allEvents');
Route::get('finished-events', 'UiController@allFinished')->name('frontend.allFinished');
Route::get('live-events', 'UiController@allLiveMatch')->name('frontend.allLiveMatch');
Route::get('up-comming-events', 'UiController@allUpComMatch')->name('frontend.allUpComMatch');
Route::get('match/details/{id}', 'UiController@moreQusDetails')->name('frontend.moreQus');

Route::get('/search', 'UiController@search')->name('search.title');

Route::post('subscriber', 'UiController@subscriberStore')->name('frontend.subscriber.store');

Route::get('register/{referral_token}', 'Auth\RegisterController@showRegistrationForm');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/forgot/password', 'Auth\ForgotPasswordController@showEmailForm')->name('user.showEmailForm');
Route::post('/forgot/send', 'Auth\ForgotPasswordController@sendResetPassMail')->name('user.resetpassword.send');
Route::get('/reset/{code}', 'Auth\ForgotPasswordController@resetPasswordForm')->name('user.resetPasswordForm');
Route::post('/reset/password', 'Auth\ForgotPasswordController@resetPassword')->name('user.resetPassword');

Route::get('/authorization', 'UiController@authorization')->name('authorization');
Route::post('/sendemailver', 'UiController@sendemailver')->name('sendemailver');
Route::post('/emailverify', 'UiController@emailverify')->name('emailverify');
Route::post('/g2fa-verify', 'UiController@verify2fa')->name('go2fa.verify');

Route::get('/change-lang/{lang}', 'UiController@changeLang')->name('lang');

Route::get('category/{slug}', 'UiController@categories')->name('ui.category');
Route::get('tournament/{cat_slug}/{slug}', 'UiController@tournament')->name('ui.tournament');


Route::group(['middleware' => ['auth','ckstatus'],'namespace'=> 'User'], function() {

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('bet-log', 'HomeController@myPredictindex')->name('my.prediction');

    Route::get('tournaments/{cat_slug}/{slug}', 'HomeController@tournament')->name('tournament');

    Route::get('deposit', 'DepositController@index')->name('deposit.index');
    Route::post('deposit-confirm', 'DepositController@depositPayNow')->name('deposit.confirm');
    Route::get('deposit-log', 'DepositController@depositLog')->name('user.deposit.log');

    Route::get('predict/{team_1}/vs/{team_2}/{id}', 'HomeController@predictIndex')->name('predict.details.index');
    Route::get('prediction-list', 'HomeController@allPrediction')->name('all.predict.index');
    Route::post('prediction', 'HomeController@prediction')->name('user.prediction');

    Route::get('referral/{level?}', 'HomeController@myRef')->name('user.ref.index');

    Route::get('profile-setting', 'HomeController@profileIndex')->name('profile.index');
    Route::post('profile-setting', 'HomeController@profileUpdate')->name('profile.update');
    Route::get('change-password', 'HomeController@passwordIndex')->name('password.index');
    Route::post('password', 'HomeController@passwordUpdate')->name('password.update');

    Route::get('ticket', 'TicketController@userSupportIndex')->name('user.support.index');
    Route::get('ticket/new', 'TicketController@ticketCreate')->name('user.new.ticket');
    Route::post('store/ticket', 'TicketController@ticketStore')->name('ticket.store');
    Route::get('comment/close/{support}', 'TicketController@ticketClose')->name('ticket.close');
    Route::get('support/reply/{support}', 'TicketController@ticketReply')->name('ticket.user.reply');
    Route::post('support/store/{support}', 'TicketController@ticketReplyStore')->name('store.user.reply');

    Route::get('withdraw', 'HomeController@withdrawIndex')->name('user.withdraw.method');
    Route::post('withdraw/preview', 'HomeController@withdrawPreview')->name('withdraw.preview.user');
    Route::post('withdraw/confirm', 'HomeController@storeWithdraw')->name('confirm.withdraw.store');
    Route::get('withdraw-log', 'HomeController@withdrawLog')->name('user.withdraw.log');

    Route::get('transaction-log', 'HomeController@transactionLog')->name('user.transaction.log');
    Route::get('search-transaction/', 'HomeController@searchTrans')->name('search.trans.user');

    Route::get('/twofactor', 'HomeController@twoFactorIndex')->name('two.factor.index');
    Route::post('/g2fa-create', 'HomeController@create2fa')->name('go2fa.create');
    Route::post('/g2fa-disable', 'HomeController@disable2fa')->name('disable.2fa');

});

Route::get('/admin', 'Admin\AdminLoginController@showAdminLoginForm');
Route::post('/admin-login', 'Admin\AdminLoginController@adminLogin')->name('admin.login');

Route::group(['middleware' => ['auth:admin', 'demo'] ,'prefix' => 'admin','namespace'=> 'Admin'], function() {

    Route::get('dashboard', 'AdminController@adminIndex')->name('admin.home');
    Route::get('logout', 'AdminController@adminLogout')->name('admin.logout');

    Route::get('profile', 'AdminController@changeProfile')->name('admin.changeProfile');
    Route::post('profile/updateProfile', 'AdminController@updateProfile')->name('admin.updateProfile');

    Route::group(['middleware' => 'permission'], function() {

        Route::post('general', 'GeneralController@generalStore')->name('general.store');
        Route::post('general-nav-sidebar', 'GeneralController@navSideUpdate')->name('general.nav.sidebar');

        Route::get('logo-favicon', 'GeneralController@logoFavicon')->name('admin.logo-favicon.index');
        Route::get('general-setting', 'GeneralController@gnlSetting')->name('admin.gnl.index');
        Route::get('about', 'GeneralController@aboutIndex')->name('admin.about.index');
        Route::get('contact', 'GeneralController@contactIndex')->name('admin.contact.index');
        Route::get('extensions', 'GeneralController@extensIndex')->name('admin.extens.index');
        Route::get('section-manage', 'GeneralController@sectionIndex')->name('manage.section.index');
        Route::post('section-manage/{id}/update', 'GeneralController@sectionUpdate')->name('section-manage.update');
        Route::get('sports-api', 'GeneralController@apiIndex')->name('sports.api.index');

        Route::get('users', 'AdminController@usersIndex')->name('admin.user.manage');
        Route::get('users/detail/{id}', 'AdminController@indexUserDetail')->name('user.view');
        Route::put('users/update/{id}', 'AdminController@userUpdate')->name('user.detail.update');
        Route::get('active-user', 'AdminController@usersActiveIndex')->name('active.user.manage');
        Route::get('ban-user', 'AdminController@usersBanndedIndex')->name('ban.user.manage');
        Route::get('user/email-unverified', 'AdminController@usersUnverifiedIndex')->name('email.unverified.user');
        Route::GET('user/search', 'AdminController@userSearch')->name('username.search');
        Route::GET('user/search/email', 'AdminController@userSearchEmail')->name('email.search');

        Route::get('user/password/{id}', 'AdminController@passwordSetting')->name('user.password');
        Route::put('user/updatePassword/{id}', 'AdminController@updatePassword')->name('user.pass-update');

        Route::get('/user/balance/{id}', 'AdminController@indexUserBalance')->name('user.balance');
        Route::post('user/balance/{id}', 'AdminController@indexBalanceUpdate')->name('user.balance.update');

        Route::get('/user/mail/{id}', 'AdminController@userSendMail')->name('user.email');
        Route::post('user/send/mail', 'AdminController@userSendMailUser')->name('send.mail.user');

        Route::get('/user/predictions/{id}', 'AdminController@predictions')->name('user.predictions');
        Route::get('/user/payment/logs/{id}', 'AdminController@paymentLog')->name('user.paymentLog');
        Route::get('/user/withdraw/logs/{id}', 'AdminController@withdrawLog')->name('user.withdrawLog');
        Route::get('/user/trx/{id}', 'AdminController@transactionLog')->name('user.transactionLog');

        Route::get('transactions', 'AdminController@transactionIndex')->name('transaction.log.admin');
        Route::get('search-transaction/', 'AdminController@searchResult')->name('search.trans.admin');

        Route::get('custom-css','GeneralController@customCss')->name('admin.custom.css');
        Route::post('custom-css','GeneralController@customCssSubmit')->name('admin.custom.css.update');
        
        Route::resource('faq', FaqsController::class);
        Route::resource('testimonial', TestimonialController::class);
        Route::get('news/search', 'BlogController@newsSearch')->name('news.search');
        Route::resource('news', BlogController::class);
        Route::resource('news-category', BlogCategoryController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('social', SocialController::class);
        Route::resource('service', ServiceController::class);
        Route::resource('extra-page', ExtraPageController::class);
        Route::resource('section', SectionController::class);

        Route::get('referral', 'AdminController@referralIndex')->name('admin.referral.index');
        Route::post('referral', 'AdminController@referralStore')->name('admin.referral.update');

        Route::resource('language', LanguageController::class);
        Route::put('language-key-update/{id}', 'LanguageController@keyUpdate')->name('language-key-update');
        Route::post('language-import', 'LanguageController@langImport')->name('import_lang');

        Route::resource('extension', ExtensionController::class);
        Route::post('extension/update/{id}', 'ExtensionController@exUpdate')->name('admin.extension.update');
        Route::post('extension/activate', 'ExtensionController@activate')->name('extension.activate');
        Route::post('extension/deactivate', 'ExtensionController@deactivate')->name('extension.deactivate');

        Route::resource('advertise', AdvertiseController::class);
        Route::get('banner/advertise', 'AdvertiseController@indexBanner')->name('admin.advertise.banner');
        Route::get('script/advertise', 'AdvertiseController@indexScript')->name('admin.advertise.script');

        Route::get('manual/gateway', 'GatewayController@ManualIndex')->name('admin.manual.gateway');
        Route::resource('gateway', GatewayController::class);

        Route::get('withdraw/requests', 'WithdrawMethodController@withdrawRequest')->name('admin.withdraw.request');
        Route::get('withdraw/details/{id}', 'WithdrawMethodController@detailWithdraw')->name('admin.withdraw.detail');
        Route::post('withdraw/update/{id}', 'WithdrawMethodController@repondWithdraw')->name('admin.withdraw.process');
        Route::get('withdraw/log', 'WithdrawMethodController@showWithdrawLog')->name('admin.withdraw.viewlog');
        Route::GET('withdraw/log/search', 'WithdrawMethodController@withdLogSearch')->name('withdraw_log.search');
        Route::resource('withdraw', WithdrawMethodController::class);

        Route::resource('email-template', EmailTemplateController::class);
        Route::get('email-controls', 'EmailTemplateController@emailControl')->name('admin.email-controls');
        Route::post('email-controls', 'EmailTemplateController@emailConfigure')->name('admin.email-controls.update');
        Route::get('global-template', 'EmailTemplateController@globalControl')->name('admin.global-template');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email-template.update');

        Route::resource('subscriber', SubscriberController::class);
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('admin.subscriber.mail');

        Route::resource('support', SupportController::class);
        Route::post('/reply/{support}', 'SupportController@adminReply')->name('store.admin.reply');

        Route::get('deposit/pending','DepositController@pending')->name('admin.deposit.pending');
        Route::get('deposit/showReceipt', 'DepositController@showReceipt')->name('admin.deposit.showReceipt');
        Route::post('deposit/accept', 'DepositController@accept')->name('admin.deposit.accept');
        Route::post('deposit/rejectReq','DepositController@rejectReq')->name('admin.deposit.rejectReq');
        Route::get('deposit/acceptedRequests','DepositController@acceptedRequests')->name('admin.deposit.acceptedRequests');
        Route::get('deposit/depositLog','DepositController@depositLog')->name('admin.deposit.depositLog');
        Route::get('deposit/rejectedRequests','DepositController@rejectedRequests')->name('admin.deposit.rejectedRequests');
        Route::GET('deposit/log/search', 'DepositController@depoLogSearch')->name('deposit_log.search');

        Route::get('notifications','AdminController@notifications')->name('admin.notifications');
        Route::get('notification/read/{id}','AdminController@notificationRead')->name('admin.notification.read');
        Route::get('notifications/read-all','AdminController@readAll')->name('admin.notifications.readAll');

        Route::resource('category', CategoryController::class);
        Route::resource('tournament', BettingController::class);

        Route::get('/bets/all', 'BetLogController@index')->name('admin.all.bets');
        Route::get('/bets/pending', 'BetLogController@index')->name('admin.pending.bets');
        Route::get('/bets/won', 'BetLogController@index')->name('admin.won.bets');
        Route::get('/bets/lose', 'BetLogController@index')->name('admin.lost.bets');
        Route::get('/bets/refunded', 'BetLogController@index')->name('admin.refunded.bets');

        Route::get('/events/all', 'BettingController@matches')->name('admin.all.matches');
        Route::get('/events/running', 'BettingController@runMatches')->name('admin.runing.matches');
        Route::get('/events/upcoming', 'BettingController@upcomeMatches')->name('admin.upcoming.matches');
        Route::get('/events/closed', 'BettingController@closeMatches')->name('admin.close.event');
        Route::get('/events/create', 'BettingController@addMatch')->name('admin.add.match');
        Route::post('/events/create', 'BettingController@saveMatch')->name('admin.store.match');
        Route::get('/events/edit/{id}', 'BettingController@editMatch')->name('admin.edit.match');
        Route::put('/events/{id}/update', 'BettingController@updateMatch')->name('admin.update.match');

        Route::get('/events/question/{id}', 'BettingController@viewQuestion')->name('admin.view.question');
        Route::post('/events/add-question', 'BettingController@saveQuestion')->name('admin.save.question');
        Route::post('/events/question-update', 'BettingController@updateQuestion')->name('admin.update.question');

        Route::get('/events/options/{id}', 'BettingController@viewOption')->name('admin.view.option');
        Route::post('/events/options', 'BettingController@createNewOption')->name('admin.createNewOption');
        Route::post('/events/option-update', 'BettingController@updateOption')->name('admin.update.option');

        Route::get('/result', 'BettingController@endDateByQuestion')->name('admin.awaiting.winner');
        Route::post('result', 'BettingController@refundBetInvest')->name('admin.refundBetInvest');

        Route::get('/result/predictor-list/{id}', 'BettingController@awaitingWinnerUserlist')->name('admin.awaiting.winner.userlist');
        Route::post('/result/refundSingleUser', 'BettingController@refundBetInvestSingleUser')->name('admin.refundBetInvestSingleUser');

        Route::get('/result/for-winner-select/{id}', 'BettingController@viewOptionEndTime')->name('admin.view.option.endtime');
        Route::post('/result/make-winner', 'BettingController@makeWinner')->name('admin.make.winner');
        Route::get('/result/predictor-list/option/{id}', 'BettingController@betOptionUserlist')->name('admin.bet-option-userlist');

        Route::resource('roles', RoleController::class);
        Route::resource('admin-users', AdminUserController::class);
        Route::resource('permissions', PermissionsController::class);

        Route::get('seo-manage', 'GeneralController@seoMng')->name('admin.seo.global');
    });
});

Route::get('payment', 'User\PayPalController@payment');
Route::get('cancel', 'User\PayPalController@cancel')->name('paypal.payment.cancel');
Route::get('payment/success', 'User\PayPalController@success')->name('paypal.payment.success');

Route::post('/ipncoin', 'User\CoinpaymentController@ipnCoin')->name('ipn.coinpayemnt');
Route::post('/ipnstripe', 'User\StripeController@ipnstripe')->name('ipn.stripe');

Route::any('/payfast-success', 'User\PayFastController@success')->name('payfast.payment.success');
Route::any('/payfast-cancel', 'User\PayFastController@cancel')->name('payfast.payment.cancel');
Route::any('/payfast-notify', 'User\PayFastController@notify')->name('payfast.payment.notify');

Route::post('/paystack-pay', 'User\PayStackController@redirectToGateway')->name('paystack.pay');
Route::get('/paystack-payment/callback', 'User\PayStackController@handleGatewayCallback');

Route::post('/rave-pay', 'User\FlutterwaveController@initialize')->name('rave.pay');
Route::get('/rave/callback', 'User\FlutterwaveController@callback')->name('rave.callback');

Route::post('paytm-payment', 'User\PaytmController@order')->name('paytm.payment');
Route::post('paytm/callback', 'User\PaytmController@paymentCallback')->name('paytm.callback');

Route::post('skrill-ipn', 'User\SkrillPaymentController@ipn')->name('skrill.ipn');
Route::get('skrill-complete', 'User\SkrillPaymentController@complete')->name('skrill.payment.complete');
Route::get('skrill-cancelled', 'User\SkrillPaymentController@cancelled')->name('skrill.payment.cancelled');

Route::get('/authorize-pay','User\AuthorizeNetController@pay')->name('authorize.pay');
Route::any('/dopay/online', 'User\AuthorizeNetController@handleonlinepay')->name('authorize.dopay.online');

Route::get('mollie-paymnet', 'User\MollieController@preparePayment')->name('mollie.payment');
Route::get('mollie-payment-success','User\MollieController@paymentSuccess')->name('mollie.payment.success');

Route::get('instamojo-event', 'User\InstamojoController@instamojoIndex');
Route::post('instamojo-pay', 'User\InstamojoController@instamojoPay')->name('instamojo.pay');
Route::get('instamojo-pay-success', 'User\InstamojoController@instamojoSuccess')->name('instamojo.payment.success');

Route::post('sceurionpay-ipn', 'User\SecurionPayController@ipn')->name('sceurionpay.ipn');

Route::post('coingate-ipn', 'User\CoingateController@ipn')->name('coingate.ipn');
Route::get('coingate-failed', 'User\CoingateController@failed')->name('coingate.failed');
Route::get('coingate-success', 'User\CoingateController@success')->name('coingate.success');

Route::post('coinbasecommerce-ipn', 'User\CoinbasecommerceController@ipn')->name('coinbasecommerce.ipn');
Route::get('coinbasecommerce-failed', 'User\CoinbasecommerceController@failed')->name('coinbasecommerce.failed');

Route::post('twocheckout', 'User\TwocheckoutController@prepareData')->name('twocheckout.prepareData');
Route::post('twocheckout-ipn', 'User\TwocheckoutController@ipn')->name('twocheckout.ipn');
Route::get('twocheckout-success', 'User\TwocheckoutController@success')->name('twocheckout.success');
Route::get('twocheckout-failed', 'User\TwocheckoutController@failed')->name('twocheckout.failed');
