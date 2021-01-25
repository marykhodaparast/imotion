<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Slot;
use Morilog\Jalali\CalendarUtils;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $slots = Slot::all();
        $i = 1;
        if ($role->type == 'athlete') {
            return redirect()->route('athletedashboard');
            // return view('Athlete.dashboard')->with([
            //     'msg_success' => request()->session()->get('msg_success'),
            //     'msg_error' => request()->session()->get('msg_error'),
            //     'role' => $role->type,
            //     'slots' => $slots,
            //     'i' => $i
            // ]);
        } else {
            return redirect()->route('admin_dashboard');
            // return view('Admin.dashboard')->with([
            //     'msg_success' => request()->session()->get('msg_success'),
            //     'msg_error' => request()->session()->get('msg_error'),
            //     'role' => $role->type,
            //     'slots' => $slots,
            //     'i' => $i
            // ]);
        }
    }
}
