<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loan;
use App\Models\PaymentRequest;
use App\Models\Transaction;
use App\Models\User;
use DB;

class HomeController extends Controller
{

//     Route::get('/', function () {
//     if (Auth::check()) {
//         return (auth()->user()->role->id === 1)
//             ? redirect()->route('administrator.home')
//             : redirect()->route('client.home');
//     } else {
//         return redirect()->route('login');
//     }
// });


    /** Display Admin dashboard **/
    public function index()
    {
        // return view('administrator.index', ['loans' => \App\models\Loan::take(10)->latest()->get()]);
        $user      = auth()->user();
        $user_role_id = $user->role_id;
        $data      = array();

        $data['active_customer']     = User::where('role_id', '2')->count();
        $data['inactive_customer']   = User::where('role_id', '2')->count();
        $data['recent_transactions'] = Transaction::limit(10)
            // ->with('currency')
            ->orderBy('created_at', 'desc')
            ->get();

        return view("backend.admin.dashboard", $data);
    }
}
