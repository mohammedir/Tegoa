<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\API\PassengerController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!.
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

Route::post('passenger_register',[AuthController::class,'passenger_register'])->middleware('localization');
Route::post('driver_register',[AuthController::class,'driver_register'])->middleware('localization');
Route::post('passenger_login',[AuthController::class,'passenger_login'])->middleware('localization');
Route::post('driver_login',[AuthController::class,'driver_login'])->middleware('localization');
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('user',[AuthController::class,'index'])->middleware('auth:sanctum');
Route::get('settings',[PassengerController::class,'settings']);
Route::post('fcm_token',[AuthController::class,'fcm_token'])->middleware('auth:sanctum');

Route::controller(GuestController::class)
    ->middleware('localization')
    ->group(function () {
        Route::get('/stations', 'stations')->name('stations');
        Route::get('/map', 'map')->name('map');
        Route::get('/tourism_activities', 'tourism_activities')->name('tourism_activities');
        Route::get('/tour_guids', 'tour_guids')->name('tour_guids');
        Route::get('/contact_emergency', 'contact_emergency')->name('contact_emergency');
        Route::get('/news', 'news')->name('news');
        Route::get('/announcements', 'announcements')->name('announcements');
    });
Route::controller(PassengerController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/passenger/edit_profile', 'edit_profile');
        Route::post('/passenger/update_profile', 'update_profile')->middleware('localization');
        Route::post('/passenger/change_password', 'change_password')->middleware('localization');
        Route::get('/passenger/reset-password-with-email', 'reset_password_with_email')->middleware('localization');
        Route::post('/passenger/find_transportion', 'find_transportion')->middleware('localization');
        Route::get('/passenger/my_transportion', 'my_transportion')->middleware('localization');
        Route::post('/passenger/send_email_verification ', 'verification_email')->middleware('localization');
        Route::post('/passenger/rating ', 'rating')->middleware('localization');
        Route::post('/passenger/report_driver ', 'report_driver')->middleware('localization');

    });
Route::controller(DriverController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/driver/edit_profile', 'edit_profile');
        Route::post('/driver/update_profile', 'update_profile')->middleware('localization');
        Route::get('/driver/reset-password-with-email', 'reset_password_with_email')->middleware('localization');
        Route::post('/driver/change_password', 'change_password')->middleware('localization');
        Route::post('/driver/edit_car', 'update_car')->middleware('localization');
        Route::post('/driver/find_transportion', 'find_transportion');
        Route::post('/driver/accept_transportion', 'accept_transportion')->middleware('localization');
        Route::post('/driver/start_trip', 'start_trip');
        Route::post('/driver/end_trip', 'end_trip');
        Route::post('/driver/rating ', 'rating')->middleware('localization');
        Route::post('/driver/report_passenger ', 'report_passenger')->middleware('localization');


    });
Route::get('/passenger/reset_password_view/{id}', [PassengerController::class,'reset_password_view']);
Route::post('/passenger/update-password-with-email', [PassengerController::class,'update_password_with_email']);


/*
Route::post('login',[PassengerController::class,'login'])->name('passenger.login');
Route::post('register',[PassengerController::class,'register'])->name('passenger.register');


    Route::get('user',[PassengerController::class,'index'])->name('user.index');
    Route::post('logout',[PassengerController::class,'logout'])->name('user.logout');*/
