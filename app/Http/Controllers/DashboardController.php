<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the role-appropriate dashboard.
     * Admins are redirected to admin dashboard; others see role-specific content.
     */
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('seller')) {
            return view('dashboard.seller');
        }

        return view('dashboard.buyer');
    }
}
