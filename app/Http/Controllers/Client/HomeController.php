<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // return view('client.index', ['loans' => auth()->user()->loans]);
        return view('client.index');
    }
}