<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomeController as ClientDashboardController;
use App\Http\Controllers\Client\LoanController as ClientLoanController;
use App\Http\Controllers\Admin\HomeController as AdminDashboardController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoanProductController;
use App\Http\Controllers\HomeController;


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

    Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');

        Route::name('client.')->middleware(['client'])->group(function () {

        Route::get('loans/calculator', [ClientLoanController::class, 'calculator'])->name('loans.calculator');
        Route::post('loans/calculator', [ClientLoanController::class, 'calculator'])->name('loans.calculator');

        Route::get('loans/apply_loan', [ClientLoanController::class, 'apply_loan'])->name('loans.apply_loan');
        Route::post('loans/apply_loan', [ClientLoanController::class, 'apply_loan'])->name('loans.apply_loan');

        Route::get('loans/my_loans', [ClientLoanController::class, 'index'])->name('loans.my_loans');

    });

//     /** Admin Only Route **/
            Route::name('admin.')->middleware(['admin'])->group(function () {

            //Loan Product Controller
            Route::resource('loan_products', LoanProductController::class);

            //User Controller
            Route::get('users/get_table_data/{status?}', [UserController::class, 'get_table_data']);
            Route::resource('users', UserController::class);

            //Loan Controller
            Route::resource('loans', AdminLoanController::class);
    });


});
