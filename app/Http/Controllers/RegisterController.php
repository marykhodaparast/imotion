<?php

namespace App\Http\Controllers;

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
        $provinces = Province::pluck('name', 'id');
        return view('layouts.register', ['provinces'=>$provinces,'first_step'=>1 ]);
    }
    public function createuser(Request $request){
        if($request->getMethod()=='GET'){
            return view('layouts.register', [
                "error" => "اطلاعات صحیح ارسال نشده است",
                'provinces'=>[] ,
                'first_step'=>1
            ]);
        }

        $userCount = User::where('email', $request->input('mobile'))->count();
        if ($userCount > 0) {
            $provinces = Province::pluck('name', 'id');
            return view('layouts.register', [
                'provinces'=>$provinces ,
                "error" => "تلفن همراه {$request->input('mobile')} قبلا ثبت نام شده است" ,
                'first_step'=>1
                ]);
        }
        $res = Sms_validation::where('mobile', $request->input('mobile'))->where('sms_code', $request->input('sms_code'))->first();
        $user = new User;
        $userInfo = json_decode($res->user_info);
        $user->email = $userInfo->mobile;
        $user->password = Hash::make($request->input('password'));
        $user->first_name = $userInfo->fname;
        $user->last_name = $userInfo->lname;
        $group = Group::select('id')->where('name','Marketer')->first();
        $user->groups_id = $group->id;
        $user->save();
        $marketer  = new Marketer;
        $marketer->users_id = $user->id;
        $marketer->first_name = $userInfo->fname;
        $marketer->last_name = $userInfo->lname;
        $marketer->cell_phone = $userInfo->mobile;
        $marketer->provinces_id = $userInfo->province;
        $marketer->city = $userInfo->city;
        $marketer->save();
        Sms_validation::where('mobile',$userInfo->mobile)->delete();
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
