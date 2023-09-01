<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
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
    public function login()
    {
        return view('');
    }

    public function logouts()
    {
        Auth::logout();
        return redirect()->route('');
    }
}
