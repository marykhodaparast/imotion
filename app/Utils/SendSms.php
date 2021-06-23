<?php
namespace App\Utils;
use Illuminate\Http\Request;
use App\SmsValidation;
use App\User;


class SendSms{

    public function sendCode($receptor,$token){

        $api_key = "553133726A6962423652346246504B544C72766668784A6E384C61682B4D565349756B2B374D374C4A6D553D";
        $url = "https://api.kavenegar.com/v1/$api_key/verify/lookup.json";
        $ch = curl_init();
        $url = $url."?receptor=$receptor&token=$token&template=aref";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
    public function sendsms(Request $request){

        if ($request->getMethod() == 'GET') {
            return view('layouts.register', [
                "error" => "اطلاعات صحیح ارسال نشده است"
            ]);
        }
        $request->validate([
            'mobile' => 'required|min:11|max:11',
            'fname' => 'required|max:100',
            'lname' => 'required|max:100',
        ]);
        $userCount = User::where('email', $request->input('mobile'))->count();
        if ($userCount > 0) {
            return view('layouts.register', [
                "error" => "تلفن همراه {$request->input('mobile')} قبلا ثبت نام شده است" ,
                'first_step'=>1
                ]);
        }
        $sms = new SmsValidation;
        $sms->mobile = $request->input('mobile');
        $sms_code = rand(1000, 9999);
        $sms->sms_code = $sms_code;
        $user_info = [
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'mobile' => $request->input('mobile')
        ];
        $sms->user_info = json_encode($user_info, JSON_UNESCAPED_UNICODE);
        SmsValidation::where('mobile', $sms->mobile)->delete();
        $sms->save();
        $this->sendCode($sms->mobile,$sms_code);
        $smsMessage = "لطفا کد پیامک شده را وارد نمایید";
        return view('layouts.register',
            [
            'smsMessage'=>$smsMessage ,
            'mobile'=>$sms->mobile,
            'second_step'=>1
            ]);
    }
    public function checksms(Request $request){

        if($request->getMethod()=='GET'){
            return view('layouts.register', [
                "error" => "اطلاعات صحیح ارسال نشده است",
                'second_step'=>1
            ]);
        }
        $request->validate([
            'sms_code' => 'required|min:4|max:4'
        ]);
        $res = SmsValidation::where('mobile',$request->input('mobile'))->where('sms_code',$request->input('sms_code'))->count();
        if($res<=0){
            return view('layouts.register',
            [
                'smsMessage'=>'کد وارد شده صحیح نیست' ,
                'mobile'=>$request->input('mobile'),
                'second_step'=>1
            ]);
        }
        $smsMessage = "جهت ورود به سیستم در آینده لطفا رمز عبور خود را تعیین کنید ";
        return view('layouts.register',
            [
                'smsMessage'=>$smsMessage ,
                'mobile'=>$request->input('mobile'),
                'sms_code'=>$request->input('sms_code'),
                'third_step'=>1
            ]);
    }
   
}