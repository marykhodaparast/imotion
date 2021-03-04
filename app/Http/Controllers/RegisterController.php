<?php

namespace App\Http\Controllers;

use App\Athlete;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sms_validation;
use App\Province;
use App\User;
use App\Marketer;
use App\Group;
use App\Role;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            return view('layouts.register', [
                "error" => "قبلا ثبت نام کرده اید",
                'first_step'=>1
            ]);
        }
        //$provinces = Province::pluck('name', 'id');
        return view('layouts.register',
         [//'provinces'=>$provinces,
         'first_step'=>1 ]);
    }
    public function createuser(Request $request){

        if($request->getMethod()=='GET'){
            return view('layouts.register');
        }

        $request->validate([
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'cell' => 'required|numeric|min:11',
        ]);

        // dd($request->all());
        $userCount = User::where('email', $request->input('cell'))->count();
        if ($userCount > 0) {
            return view('layouts.register', [
                "custom_error" => "تلفن همراه {$request->input('cell')} قبلا ثبت نام شده است" 
            ]);
        }
        
        $athleteRole = Role::where("type", "athlete")->first();
        if($athleteRole)
            $athleteRole = $athleteRole->id;
        else 
            $athleteRole = 1;

        $user = new User;
        $user->email = $request->input('cell');
        $user->password = Hash::make($request->input('password'));
        $user->name = $request->fname.' '.$request->lname;
        $user->role_id = $athleteRole;
        $user->save();
        

        $athlete = new Athlete;
        $athlete->first_name = $request->input('fname');
        $athlete->last_name = $request->input('lname');
        $athlete->cell = $request->input('cell');
        $athlete->users_id = $user->id;
        $athlete->email = $request->input('email');
        $athlete->father_name = $request->input('father_name');
        $athlete->birthdate = $request->input('birthdate');
        $athlete->address = $request->input('address');
        $athlete->id_number = $request->input('id_number');
        $athlete->education = $request->input('education');
        $athlete->job = $request->input('job');
        $athlete->position = $request->input('position');
        $athlete->cell_telegram = $request->input('cell_telegram');
        $athlete->emergency_phone = $request->input('emergency_phone');
        $athlete->referrer = $request->input('referrer');
        $athlete->ems_exp = $request->input('ems_exp');
        $athlete->sport_exp = $request->input('sport_exp');
        $athlete->diet_weekly_call = isset($request->all['diet_weekly_call']);
        $athlete->before_session_call = isset($request->all['before_session_call']);
        $athlete->goal_muscle = isset($request->all['goal_muscle']);
        $athlete->goal_ass_nice = isset($request->all['goal_ass_nice']);
        $athlete->goal_fat = isset($request->all['goal_fat']);
        $athlete->goal_ass_small = isset($request->all['goal_ass_small']);
        $athlete->goal_belly_small = isset($request->all['goal_belly_small']);
        $athlete->goal_belly_nice = isset($request->all['goal_belly_nice']);
        $athlete->goal_tit_small = isset($request->all['goal_tit_small']);
        $athlete->goal_arm_muscle = isset($request->all['goal_arm_muscle']);
        $athlete->goal_foot_nice = isset($request->all['goal_foot_nice']);
        $athlete->goal_arm_small = isset($request->all['goal_arm_small']);
        $athlete->goal_foot_small = isset($request->all['goal_foot_small']);
        $athlete->goal_back_nice = isset($request->all['goal_back_nice']);
        $athlete->goal_other = isset($request->all['goal_other']);
        $athlete->description = isset($request->all['description']);
        $athlete->save();

        return redirect()->route('login');
    }
}
