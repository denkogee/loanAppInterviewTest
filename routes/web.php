<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomeController as ClientDashboardController;
use App\Http\Controllers\Client\LoanController as ClientLoanController;
use App\Http\Controllers\Admin\HomeController as AdminDashboardController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\UserController;


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

// Route::get('/well', function () {
//     return view('welcome');
// });

Auth::routes([
    'verify'   => false,
    'register' => false,
    'login'    => true,
    'logout'   => true,
    'reset'    => false,
    'confirm'  => false,
]);

Route::get('/', function () {

    if (Auth::check()) {
        return (auth()->user()->role_id === 1)
            ? redirect()->route('admin.home')
            : redirect()->route('client.home');
    } else {
        return redirect()->route('login');
    }

});

// Route::get('/logout', 'Auth\LoginController@logout');
// Route::resource('logout',  ClientLoanController::class);

Route::group(['middleware' =>  ['auth']], function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.index');

// // Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
// // Route::get('/logout', 'Auth\LoginController@logout');

    // Route::group(['middleware' => ['client']], function () {
        Route::name('client.')->middleware(['client'])->group(function () {
        Route::get('/', [ClientDashboardController::class, 'index'])->name('home');
        Route::resource('loans',  ClientLoanController::class);
    });

//     /** Admin Only Route **/
    // Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'name' => 'admin'], function () {
        // Route::prefix('admin')->name('admin.')->middleware(['auth', 'permitted.user'])->group(function () {
            Route::name('admin.')->middleware(['admin'])->group(function () {

            // Route::resource('users', 'UserController');
            // Route::get('/', [UserController::class, 'index'])->name('dashboard.index');

            //User Controller
            Route::get('users/get_table_data/{status?}', [UserController::class, 'get_table_data']);
            Route::resource('users', UserController::class);

            //Loan Controller
            Route::resource('loans', LoanController::class);


//         Route::get('loans/toggle-status/{uuid}/{status}', [AdminLoanController::class, 'toggleStatus'])->name('loans.toggle_status');
//         Route::resource('loans',  LoanController::class);

//         // Route::get('dashboard', [AdminController::class, 'index'])->name('admin');
//         //User Roles
//         // Route::resource('roles', 'RoleController');
//         //Permission Controller
//         // Route::get('permission/control/{user_id?}', 'PermissionController@index')->name('permission.index');
//         // Route::post('permission/store', 'PermissionController@store')->name('permission.store');

//         // Route::match(['get', 'post'], 'administration/system_settings/{view?}', 'UtilityController@system_settings')->name('settings.system_settings');
//         // Route::match(['get', 'post'], 'theme_option/{store?}', 'UtilityController@theme_option')->name('theme_option.update');
    });


});
