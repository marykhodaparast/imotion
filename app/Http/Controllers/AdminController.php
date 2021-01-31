<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\CalendarUtils;
use Exception;
use App\Slot;
use App\User;

class AdminController extends Controller
{
    public static function persianToEnglishDigits($pnumber)
    {
        $number = str_replace('۰', '0', $pnumber);
        $number = str_replace('۱', '1', $number);
        $number = str_replace('۲', '2', $number);
        $number = str_replace('۳', '3', $number);
        $number = str_replace('۴', '4', $number);
        $number = str_replace('۵', '5', $number);
        $number = str_replace('۶', '6', $number);
        $number = str_replace('۷', '7', $number);
        $number = str_replace('۸', '8', $number);
        $number = str_replace('۹', '9', $number);
        return $number;
    }
    public static function jalaliToGregorian($pdate)
    {
        $pdate = explode('-', AthleteController::persianToEnglishDigits($pdate));
        $date = "";
        if (count($pdate) == 3) {
            $y = (int)$pdate[0];
            $m = (int)$pdate[1];
            $d = (int)$pdate[2];
            if ($d > $y) {
                $tmp = $d;
                $d = $y;
                $y = $tmp;
            }
            $y = (($y < 1000) ? $y + 1300 : $y);
            $gregorian = CalendarUtils::toGregorian($y, $m, $d);
            $gregorian = $gregorian[0] . "-" . $gregorian[1] . "-" . $gregorian[2];
        }
        return $gregorian;
    }
    public function giveSlotsOfSpecificDateAndTime($date, $time)
    {
        $arr = explode('-', $time);
        $start = trim($arr[0]);
        $end = trim($arr[1]);
        $slot = SLot::where('start', $start)->where('end', $end)->where('date', $this->jalaliToGregorian($date))->first();
        if ($slot) {
            return [
                [$slot->first_athlete ? $slot->first_athlete->id : 0, $slot->first_athlete ? $slot->first_athlete->first_name . ' ' . $slot->first_athlete->last_name : null],
                [$slot->second_athlete ? $slot->second_athlete->id : 0, $slot->second_athlete ? $slot->second_athlete->first_name . ' ' . $slot->second_athlete->last_name : null],
                [$slot->third_athlete ? $slot->third_athlete->id : 0,  $slot->third_athlete ? $slot->third_athlete->first_name . ' ' . $slot->third_athlete->last_name : null]
            ];
        }
        return [];
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $from_date = null;
        $i = 1;
        $sw = 0;
        $s = null;
        $arr = [];
        $newArr = [];
        $arrOfTimes = [
            '08:00 - 08:30',
            '08:30 - 09:00',
            '09:00 - 09:30',
            '09:30 - 10:00',
            '10:00 - 10:30',
            '10:30 - 11:00',
            '11:00 - 11:30',
            '11:30 - 12:00',
            '12:00 - 12:30',
            '12:30 - 13:00',
            '13:00 - 13:30',
            '13:30 - 14:00',
            '14:00 - 14:30',
            '14:30 - 15:00',
            '15:00 - 15:30',
            '15:30 - 16:00',
            '16:00 - 16:30',
            '16:30 - 17:00',
            '17:00 - 17:30',
            '17:30 - 18:00'
        ];
        $firstAthlete = null;
        $secondAthlete = null;
        $thirdAthlete = null;
        $start = 0;
        $end = 0;
        $athletes = [];
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role->type == 'athlete') {
                $athletes[] = $user;
            }
        }
        $user_slots = Slot::where('athlete_id_1', '!=', null)->orWhere('athlete_id_2', '!=', null)->orWhere('athlete_id_3', '!=', null)->get();
        if ($request->getMethod() == 'POST') {

            if ($request->input('time')) {
                $arr = explode('-', $request->input('time'));
                $start = trim($arr[0]);
                $end = trim($arr[1]);
            }
            // else{
            //     $request->session()->flash("msg_error", "لطفا زمان موردنظر خود را انتخاب کنید.");
            //     return redirect()->back();
            // }

            if ($request->input('date')) {
                $from_date = $this->jalaliToGregorian($request->input('date'));
            }
            // else{
            //     $request->session()->flash("msg_error", "لطفا تاریخ موردنظر خود را انتخاب کنید.");
            //     return redirect()->back();
            // }
            $found = Slot::where('start', $start)
                ->where('end', $end)
                ->where('date', $from_date)
                ->first();
            if ($found) {
                $firstAthlete = $found->athlete_id_1;
                $secondAthlete = $found->athlete_id_2;
                $thirdAthlete = $found->athlete_id_3;
                if ($firstAthlete == null) {
                    $slot = new Slot;
                    $slot->start = $start;
                    $slot->end = $end;
                    $slot->date = $from_date;
                    $slot->athlete_id_1 = Auth::user()->id;
                    try {
                        $slot->save();
                        $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                        return redirect()->back();
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != null && $secondAthlete == null) {
                    $found->athlete_id_2 = Auth::user()->id;
                    try {
                        if ($firstAthlete != $found->athlete_id_2) {
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        } else {
                            $request->session()->flash("msg_error", "شما قبلا در این تایم ثبت نام کرده اید!");
                            return redirect()->back();
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != null && $secondAthlete != null && $thirdAthlete == null) {
                    $found->athlete_id_3 = Auth::user()->id;
                    try {
                        if ($firstAthlete != $found->athlete_id_3  && $secondAthlete !=  $found->athlete_id_3) {
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        } else {
                            $request->session()->flash("msg_error", "شما قبلا در این تایم ثبت نام کرده اید!");
                            return redirect()->back();
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != null && $secondAthlete != null && $thirdAthlete != null) {
                    $request->session()->flash("msg_error", "در این تایم نوبت ها پر شده است.");
                    return redirect()->back();
                }
            } else {
                $slot = new Slot;
                $slot->start = $start;
                $slot->end = $end;
                $slot->date = $from_date;
                $slot->athlete_id_1 = Auth::user()->id;
                try {
                    $slot->save();
                    $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                    return redirect()->back();
                } catch (Exception $e) {
                    dd($e);
                }
            }
        }
        $theUserSlots = [];
        for ($i = 1; $i <= 10; $i++) {
            $theUserSlots[jdate()->addDays($i - 1)->format('Y-m-d')] = "";
        }
        $slotIndex = [
            "08:00:00" => 1,
            "08:30:00" => 2,
            "09:00:00" => 3,
            "09:30:00" => 4,
            "10:00:00" => 5,
            "10:30:00" => 6,
            "11:00:00" => 7,
            "11:30:00" => 8,
            "12:00:00" => 9,
            "12:30:00" => 10,
            "13:00:00" => 11,
            "13:30:00" => 12,
            "14:00:00" => 13,
            "14:30:00" => 14,
            "15:00:00" => 15,
            "15:30:00" => 16,
            "16:00:00" => 17,
            "16:30:00" => 18,
            "17:00:00" => 19,
            "17:30:00" => 20,
        ];
        foreach ($user_slots as $user_slot) {
            $date = jdate($user_slot->date)->format('Y-m-d');
            if (isset($theUserSlots[$date])) {
                $theUserSlots[$date] = $slotIndex[$user_slot->start];
            }
        }

        foreach ($theUserSlots as $date => $slot) {
            $Edate = $this->jalaliToGregorian($date);
            $s = SLot::where('athlete_id_1', '!=', null)->where('athlete_id_2', '!=', null)->where('athlete_id_3', '!=', null)->where('date', $Edate)->get();
            if ($s != null) {
                foreach($s as $item){
                    $arr[] = $slotIndex[$item->start]."_banned";
                    $theUserSlots[$date] = $arr;

                }
            }
        }
        //dd($theUserSlots);

        //dd($theUserSlots);
        return view('Admin.dashboard')->with([
            'from_date' => $from_date,
            'arrOfTimes' => $arrOfTimes,
            'msg_success' => request()->session()->get('msg_success'),
            'msg_error' => request()->session()->get('msg_error'),
            'role' => $role->type,
            'user_slots' => $theUserSlots,
            'i' => $i,
            'athletes' => $athletes
        ]);
    }
    public function saveNewSlot(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        $firstAthlete = $request->input('first_athlete');
        $secondAthlete = $request->input('second_athlete');
        $thirdAthlete = $request->input('third_athlete');
        $arr = explode('-', $request->input('time'));
        $start = trim($arr[0]);
        $end = trim($arr[1]);
        $slot = Slot::where('date',$this->jalaliToGregorian($date))->where('start',$start)->where('end',$end)->first();
        if($slot == null){
            $s = new Slot;
            $s->date = $this->jalaliToGregorian($date);
            $s->start = $start;
            $s->end = $end;
            $s->athlete_id_1 = $firstAthlete;
            $s->athlete_id_2 = $secondAthlete;
            $s->athlete_id_3 = $thirdAthlete;
            $s->save();
            $request->session()->flash("msg_success", "با موفقیت ثبت شد.");
            return redirect()->back();
        }
        $slot->athlete_id_1 = $firstAthlete ? $firstAthlete : $slot->athlete_id_1;
        $slot->athlete_id_2 = $secondAthlete ? $secondAthlete : $slot->athlete_id_2;
        $slot->athlete_id_3 = $thirdAthlete ? $thirdAthlete : $slot->athlete_id_3;
        $slot->save();
        $request->session()->flash("msg_success", "با موفقیت ثبت شد.");
        return redirect()->back();
    }
    //-------------------------AJAX---------------------------//
    public function ajaxCall(Request $request)
    {
        $theTime = $request->input('theTime');
        $theDate = $request->input('theDate');
        $arr = $this->giveSlotsOfSpecificDateAndTime($theDate, $theTime);
        return [
            'data' => $arr,
            'error' => 'error'
        ];
    }
}
