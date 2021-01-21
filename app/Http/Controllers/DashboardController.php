<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Student;
use App\Group;
use App\User;
use Morilog\Jalali\CalendarUtils;

class DashboardController extends Controller
{

    public function index(){
        $user = Auth::user();
        $role = $user->role;
        // if($role->type == 'admin'){
        //     dd('hello admin');
        // }
        if($role->type == 'athlete'){
            return view('Athlete.dashboard');
        }else{
            dd('admin');
        }

        // return view('dashboard.admin', [
        //     'devideStudents'=>$devideStudents,
        //     'todayStudents'=>$todayStudents,
        //     'results'=>$results,
        //     'supporters'=>$supporters
        // ]);
    }
}
