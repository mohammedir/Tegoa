<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\PermissionAdminController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RolesAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!s
|
*/
Route::group(['middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'prefix' => LaravelLocalization::setLocale()], function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', function () {
        return redirect(route('login'));
    });
    require __DIR__ . '/auth.php';

});

Route::group(['middleware' => ['auth', 'verified', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'prefix' => LaravelLocalization::setLocale()], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::get('/admin/account', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/roles', [RolesAdminController::class, 'index'])->name('roles.index');
    Route::post('/roles/store', [RolesAdminController::class, 'store'])->name('roles.store');
    Route::get('/roles/show/{id}', [RolesAdminController::class, 'show'])->name('roles.show');
    Route::post('/roles/update/{id}', [RolesAdminController::class, 'update'])->name('roles.update');
    Route::delete('/roles/destroy/{id}', [RolesAdminController::class, 'destroy'])->name('roles.destroy');
    Route::get('/permissions', [PermissionAdminController::class, 'index'])->name('roles.index');
    Route::post('/permissions/store', [PermissionAdminController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/edit/{id}', [PermissionAdminController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionAdminController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/destroy/{id}', [PermissionAdminController::class, 'destroy'])->name('permissions.destroy');

    Route::resource('cars', CarController::class);
    Route::post('/accept/car', [CarController::class, 'accept']);
    Route::post('/decline/car', [CarController::class, 'decline']);
    Route::get('/delete/image/cars/', [CarController::class, 'deleteImage']);

    Route::resource('news', NewsController::class);
    Route::resource('places', PlaceController::class);
    Route::get('/get/map/', [PlaceController::class, 'map']);
    Route::get('/changeStatus/news/', [NewsController::class, 'changeStatus']);


    Route::resource('tour', TourController::class);
    Route::get('/changeStatus/', [TourController::class, 'changeStatus']);

    Route::resource('drivers', DriverController::class);
    Route::get('/changeStatus/drivers/', [DriverController::class, 'changeStatus']);


    Route::resource('passengers', PassengerController::class);



    Route::get('language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

