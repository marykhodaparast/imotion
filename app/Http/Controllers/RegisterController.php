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
            return view('layouts.register', [
                "error" => "اطلاعات صحیح ارسال نشده است",
                'provinces'=>[] ,
                'first_step'=>1
            ]);
        }else{
            $request->validate([
                'first_name' => 'required|min:3|max:255',
                'last_name' => 'required|min:3|max:255',
                'phone' => 'required|numeric|size:11',
            ]);
        }

        $userCount = User::where('email', $request->input('mobile'))->count();
        if ($userCount > 0) {
            //$provinces = Province::pluck('name', 'id');
            return view('layouts.register', [
                //'provinces'=>$provinces ,
                "error" => "تلفن همراه {$request->input('mobile')} قبلا ثبت نام شده است" ,
                'first_step'=>1
                ]);
        }
        //$res = Sms_validation::where('mobile', $request->input('mobile'))->where('sms_code', $request->input('sms_code'))->first();
        $athlete = new Athlete;
        $athlete->first_name = $request->input('fname');
        $athlete->last_name = $request->input('lname');
        $athlete->phone = $request->input('mobile');
        $athlete->role_id = 1;
        try{
            $athlete->save();
        }catch(Exception $e){
            dd($e);
        }
        $user = new User;
        //$userInfo = json_decode($res->user_info);
        $user->email = $request->email;
        $user->password = Hash::make($request->input('password'));
        $user->name = $request->fname.' '.$request->lname;
        $user->role_id = 1;
        //$user->last_name = $userInfo->lname;
        //$group = Group::select('id')->where('name','Marketer')->first();
        //$user->groups_id = $group->id;
        $user->save();
        return view(
            'layouts.register',
            [
                'smsMessage' => 'ثبت نام با موفقیت انجام شد لطفا کمی صبر کنید',
                'provinces'=>[],
                'final_step' => 1
            ]
        );
    }
}
