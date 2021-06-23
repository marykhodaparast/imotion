<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        if ($role->type == 'athlete') {
            return redirect()->route('athletedashboard');
        } else {
            return redirect()->route('admin_dashboard');
        }
    }
}
