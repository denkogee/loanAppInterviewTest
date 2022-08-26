<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $userRole      = auth()->user()->role;
        $user_role_name = $userRole->name;
        $data      = array();

        if ($user_role_name == 'client') {
            $data['loans']           = Loan::where('status', 1)->where('user_id', auth()->id())->get();

        } else {
            $data['total_client']     = User::where('role_id', '2')->count();
            $data['loans']            = Loan::where('status', 1)->get();
        }

        return view("backend.dashboard-$user_role_name", $data);
    }
}
