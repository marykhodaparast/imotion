<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slot;

class AdminController extends Controller
{
    public function dashboard(){
        $slots = Slot::all();
        return view('Admin.dashboard')->with([
            'slots' => $slots
        ]);
    }
}
