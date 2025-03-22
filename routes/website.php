<?php

use App\Http\Controllers\Admin\PageManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\frontend\AccountController;
use App\Http\Controllers\frontend\Astrologer\AstrologerController as FrontendAstrologerController;
use App\Http\Controllers\frontend\Astrologer\AuthController as AstrologerAuthController;
use App\Http\Controllers\frontend\Astrologer\CallController;
use App\Http\Controllers\frontend\Astrologer\ChatController;
use App\Http\Controllers\frontend\Astrologer\HomeController as AstrologerHomeController;
use App\Http\Controllers\frontend\Astrologer\HoroscopeController as AstrologerHoroscopeController;
use App\Http\Controllers\frontend\AstrologerCallController;
use App\Http\Controllers\frontend\AstrologerChatController;
use App\Http\Controllers\frontend\AstrologerController;
use App\Http\Controllers\frontend\AuthController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\HoroscopeController;
use App\Http\Controllers\frontend\KundaliController;
use App\Http\Controllers\frontend\PageManagementController as FrontendPageManagementController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\ReportController;
use App\Http\Controllers\frontend\WalletController;
use App\Models\UserModel\ChatRequest;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Session\Session;


// $prefix='partner';
$session = new Session();
$token = $session->get('token');
header('Authorization:Bearer '.$token);
// header('Content-Type:application/json');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');
header('Accept:application/json');
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



// Route::get('/', function () {
//     return view('home');
// });
// Route::get('/home', function () {
//     return view('home');
// });

Route::get('/getDateTime', [AstrologerChatController::class, 'getDateTime'])->name('front.getDateTime');

Route::get('privacyPolicy', [PageManagementController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('terms-condition', [PageManagementController::class, 'termscondition'])->name('termscondition');



 // Payment Related

 Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
 Route::post('payment', [PaymentController::class, 'payment'])->name('payment');
 Route::get('payment-success', [PaymentController::class, 'paymentsuccess']);
 Route::post('payment-success', [PaymentController::class, 'paymentsuccess'])->name('payment-success');
 Route::get('payment-failed', [PaymentController::class, 'paymentfailed'])->name('payment-faileds');
 Route::post('payment-failed', [PaymentController::class, 'paymentfailed'])->name('payment-failed');
 Route::get('payment-response', [PaymentController::class, 'paymentsresponse']);
 Route::post('payment-response', [PaymentController::class, 'paymentsresponse'])->name('payment-response');
//  Route::get('payment-process', [PaymentController::class, 'paymentprocess']);
 Route::post('payment-process', [PaymentController::class, 'paymentprocess'])->name('payment-process');
 Route::get('payment-pending', [PaymentController::class, 'paymentpending']);
 Route::post('payment-pending', [PaymentController::class, 'paymentpending'])->name('payment-pending');
 Route::get('payu-merchant-form', [PaymentController::class, 'payumerchantform'])->name('payumerchantform');
 Route::get('paytm-merchant-form', [PaymentController::class, 'paytmmerchantform'])->name('paytmmerchantform');



//  Frontend


// Route::group(['prefix' => 'web'], function () {

    Route::post('/verifyOTL', [AuthController::class, 'verifyOTL'])->name('front.verifyOTL');
    Route::post('/verifyOTLAstro', [AstrologerAuthController::class, 'verifyOTLAstro'])->name('front.verifyOTLAstro');

    Route::get('/', [HomeController::class, 'home'])->name('front.home');
    Route::get('/reportlist', [ReportController::class, 'reportList'])->name('front.reportList');
    Route::get('/talklist', [AstrologerCallController::class, 'talkList'])->name('front.talkList');
    Route::get('/chatlist', [AstrologerChatController::class, 'chatList'])->name('front.chatList');
    Route::get('/astrologerdetails', [AstrologerController::class, 'astrologerDetails'])->name('front.astrologerDetails');
    Route::get('/panchang', [KundaliController::class, 'getPanchang'])->name('front.getPanchang');
    Route::get('/dailyhoroscope', [HoroscopeController::class, 'dailyHoroscope'])->name('front.dailyHoroscope');
    Route::get('/horoscope', [HoroscopeController::class, 'horoScope'])->name('front.horoScope');
    Route::get('/blog', [BlogController::class, 'getBlog'])->name('front.getBlog');
    Route::get('/blog-details', [BlogController::class, 'getBlogDetails'])->name('front.getBlogDetails');
    Route::get('/products', [ProductController::class, 'getproducts'])->name('front.getproducts');
    Route::get('/product-details', [ProductController::class, 'getproductDetails'])->name('front.getproductDetails');
    Route::get('/kundali', [KundaliController::class, 'getkundali'])->name('front.getkundali');
    Route::get('/kundali-matching', [KundaliController::class, 'kundaliMatch'])->name('front.kundaliMatch');
    Route::get('/kundali-match-report', [KundaliController::class, 'kundaliMatchReport'])->name('front.kundaliMatchReport');
    Route::get('/liveastrologers', [AstrologerController::class, 'getLiveAstro'])->name('front.getLiveAstro');
    Route::get('/live', [AstrologerController::class, 'LiveAstroDetails'])->name('front.LiveAstroDetails');
    Route::get('/my-account', [AccountController::class, 'getMyAccount'])->name('front.getMyAccount');
    Route::get('/my-wallet', [WalletController::class, 'getMyWallet'])->name('front.getMyWallet');
    Route::get('/wallet-recharge', [WalletController::class, 'walletRecharge'])->name('front.walletRecharge');
    Route::get('/verifyOtp', [AuthController::class, 'verifyOtp'])->name('front.verifyOtp');
    Route::get('/logout', [AuthController::class, 'logout'])->name('front.logout');
    Route::post('/updateprofile', [AccountController::class, 'updateprofile'])->name('front.updateprofile');
    Route::get('/deleteAccount', [AccountController::class, 'deleteAccount'])->name('front.deleteAccount');
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('front.checkout');
    Route::get('/my-orders', [ProductController::class, 'myOrders'])->name('front.myOrders');
    Route::get('/my-reports', [ReportController::class, 'getMyReport'])->name('front.getMyReport');
    Route::get('/chat', [AstrologerChatController::class, 'chat'])->name('front.chat');
    Route::get('/my-chats', [AstrologerChatController::class, 'getMyChat'])->name('front.getMyChat');
    Route::get('/my-chat-history', [AstrologerChatController::class, 'getChatHistory'])->name('front.getChatHistory');
    Route::get('/call', [AstrologerCallController::class, 'call'])->name('front.call');
    Route::get('/audiocall', [AstrologerCallController::class, 'audiocall'])->name('front.audiocall');
    Route::get('/my-calls', [AstrologerCallController::class, 'getMyCall'])->name('front.getMyCall');
    Route::get('/my-following', [AccountController::class, 'getMyFollowing'])->name('front.getMyFollowing');
    Route::get('privacy-policy', [FrontendPageManagementController::class, 'privacyPolicy'])->name('front.privacyPolicy');
    Route::get('terms-condition', [FrontendPageManagementController::class, 'termscondition'])->name('front.termscondition');
    Route::get('aboutus', [FrontendPageManagementController::class, 'aboutus'])->name('front.aboutus');
    Route::get('contact', [FrontendPageManagementController::class, 'contactUS'])->name('front.contact');
    Route::post('savecontactUS', [FrontendPageManagementController::class, 'SavecontactUS'])->name('front.store.contact');


    Route::get('/astrologer/{id?}/stories', [HomeController::class, 'getAstrologerStories'])->name('front.getAstrologerStories');
    Route::post('/astrologer/viewstory', [HomeController::class, 'viewstory'])->name('front.viewstory');


// Astrologers Section
Route::middleware(['web'])->prefix('astrologer')->group(function () {
        Route::get('/login', [AstrologerAuthController::class, 'astrologerlogin'])->name('front.astrologerlogin');
        Route::get('/registration', [AstrologerAuthController::class, 'astrologerregister'])->name('front.astrologerregister');
        Route::post('/registration', [AstrologerAuthController::class, 'astrologerstore'])->name('front.astrologerstore');
        Route::get('/index', [AstrologerHomeController::class, 'index'])->name('front.astrologerindex');
        Route::get('/profileupdate', [FrontendAstrologerController::class, 'AstrologerAccount'])->name('front.profileupdate');
        Route::post('/profileupdate', [FrontendAstrologerController::class, 'updateAstrologer'])->name('front.updateAstrologer');
        Route::get('/chat', [ChatController::class, 'astrologerchat'])->name('front.astrologerchat');
        Route::get('/call', [CallController::class, 'astrologercall'])->name('front.astrologercall');
        Route::get('/check-chat-status', [ChatController::class, 'chatStatus'])->name('front.chatStatus');
        Route::get('/check-call-status', [CallController::class, 'callStatus'])->name('front.callStatus');

        Route::get('/astrologer-wallet', [FrontendAstrologerController::class, 'getAstrologerWallet'])->name('front.getAstrologerWallet');
        Route::get('/astrologer-wallet-recharge', [FrontendAstrologerController::class, 'AstrologerWalletRecharge'])->name('front.AstrologerWalletRecharge');
        Route::get('/astrologer-chats', [FrontendAstrologerController::class, 'getAstrologerChat'])->name('front.getAstrologerChat');
        Route::get('/astrologer-calls', [FrontendAstrologerController::class, 'getAstrologerCall'])->name('front.getAstrologerCall');
        Route::get('/astrologer-reports', [FrontendAstrologerController::class, 'getAstrologerReport'])->name('front.getAstrologerReport');
        Route::get('/live-astrologer', [FrontendAstrologerController::class, 'LiveAstrologers'])->name('front.LiveAstrologers');
        Route::get('/logout', [AstrologerAuthController::class, 'logout'])->name('front.astrologerlogout');

        Route::get('/kundali', [AstrologerHoroscopeController::class, 'getkundali'])->name('front.astrologers.getkundali');
        Route::get('/kundali-matching', [AstrologerHoroscopeController::class, 'kundaliMatch'])->name('front.astrologers.kundaliMatch');
        Route::get('/kundali-match-report', [AstrologerHoroscopeController::class, 'kundaliMatchReport'])->name('front.astrologers.kundaliMatchReport');
        Route::get('/panchang', [AstrologerHoroscopeController::class, 'getPanchang'])->name('front.astrologers.getPanchang');
        Route::get('/dailyhoroscope', [AstrologerHoroscopeController::class, 'dailyHoroscope'])->name('front.astrologers.dailyHoroscope');
        Route::get('/horoscope', [AstrologerHoroscopeController::class, 'horoScope'])->name('front.astrologers.horoScope');
        Route::get('aboutus', [AstrologerHoroscopeController::class, 'aboutus'])->name('front.astrologers.aboutus');
        Route::get('privacy-policy', [AstrologerHoroscopeController::class, 'privacyPolicy'])->name('front.astrologers.privacyPolicy');
        Route::get('terms-condition', [AstrologerHoroscopeController::class, 'termscondition'])->name('front.astrologers.termscondition');
        Route::get('/blog', [AstrologerHoroscopeController::class, 'getBlog'])->name('front.astrologers.getBlog');
        Route::get('/blog-details', [AstrologerHoroscopeController::class, 'getBlogDetails'])->name('front.astrologers.getBlogDetails');
        Route::get('contact', [AstrologerHoroscopeController::class, 'contactUS'])->name('front.astrologers.contact');
        Route::post('savecontactUS', [AstrologerHoroscopeController::class, 'SavecontactUS'])->name('front.astrologers.store.contact');
        Route::get('followers', [AstrologerHoroscopeController::class, 'followerslist'])->name('front.followerslist');
        Route::get('kundaliReport', [AstrologerHoroscopeController::class, 'kundaliReport'])->name('front.astrologers.kundaliReport');


});
    Route::post('/astrologer/get-chat-requests', [AstrologerHomeController::class, 'getChatRequests'])->name('astrologer.chat.requests');
    Route::post('/astrologer/get-call-requests', [AstrologerHomeController::class, 'getCallRequests'])->name('astrologer.call.requests');
    Route::post('/astrologer/get-report-requests', [AstrologerHomeController::class, 'getReportRequests'])->name('astrologer.report.requests');


    Route::get('kundaliReport', [KundaliController::class, 'kundaliReport'])->name('front.kundaliReport');



