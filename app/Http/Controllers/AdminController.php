<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        $totalUsers = Auth::user()->activeCompany->users->count();
        $totalProviders = Auth::user()->activeCompany->providers->count();
        $totalDealers = Auth::user()->activeCompany->dealers->count();
        return view('admin.welcome', compact('totalUsers', 'totalProviders', 'totalDealers'));
    }
}
