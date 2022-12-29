<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\API\PassengerController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('passenger_register',[AuthController::class,'passenger_register']);
Route::post('driver_register',[AuthController::class,'driver_register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('user',[AuthController::class,'index'])->middleware('auth:sanctum');

Route::controller(GuestController::class)
    ->group(function () {
        Route::get('/news', 'news')->name('news');
        Route::get('/announcements', 'announcements')->name('announcements');
        Route::get('/tourism_activities', 'tourism_activities')->name('tourism_activities');
        Route::get('/tour_guids', 'tour_guids')->name('tour_guids');
        Route::get('/contact_emergency', 'contact_emergency')->name('contact_emergency');
    });
Route::controller(PassengerController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/passenger/edit_profile', 'edit_profile')->name('news');
        Route::post('/passenger/update_profile', 'update_profile');
        Route::post('/passenger/change_password', 'change_password');
        Route::get('/passenger/reset-password-with-email', 'reset_password_with_email');
    });
Route::get('/passenger/reset_password_view/{id}', [PassengerController::class,'reset_password_view']);
Route::post('/passenger/update-password-with-email', [PassengerController::class,'update_password_with_email']);


/*
Route::post('login',[PassengerController::class,'login'])->name('passenger.login');
Route::post('register',[PassengerController::class,'register'])->name('passenger.register');


    Route::get('user',[PassengerController::class,'index'])->name('user.index');
    Route::post('logout',[PassengerController::class,'logout'])->name('user.logout');*/
