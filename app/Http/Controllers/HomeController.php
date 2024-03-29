<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        if (Auth::user()->level === 'admin') {
            return redirect('admin/dashboard-admin');
        }

        if (Auth::user()->level === 'keuangan') {
            return redirect('admin/dashboard-keuangan');
        }

        if (Auth::user()->level === 'owner') {
            return redirect('admin/dashboard-owner');
        }
    }
}
