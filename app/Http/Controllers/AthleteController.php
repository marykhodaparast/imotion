<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use App\Slot;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AthleteController extends Controller
{
    public function toPersianNum($number)
    {
        $number = str_replace("1", "۱", $number);
        $number = str_replace("2", "۲", $number);
        $number = str_replace("3", "۳", $number);
        $number = str_replace("4", "۴", $number);
        $number = str_replace("5", "۵", $number);
        $number = str_replace("6", "۶", $number);
        $number = str_replace("7", "۷", $number);
        $number = str_replace("8", "۸", $number);
        $number = str_replace("9", "۹", $number);
        $number = str_replace("0", "۰", $number);
        return $number;
    }

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $from_date = null;
        $i = 1;
        $sw = 0;
        $countAthleteArr = [];
        $arrayForSLotCounts = [];
        $arrOfTimes = [
            '08:00 - 08:30' => $this->toPersianNum('8'),
            '08:30 - 09:00' => $this->toPersianNum('8/5'),
            '09:00 - 09:30' => $this->toPersianNum('9'),
            '09:30 - 10:00' => $this->toPersianNum('9/5'),
            '10:00 - 10:30' => $this->toPersianNum('10'),
            '10:30 - 11:00' => $this->toPersianNum('10/5'),
            '11:00 - 11:30' => $this->toPersianNum('11'),
            '11:30 - 12:00' => $this->toPersianNum('11/5'),
            '12:00 - 12:30' => $this->toPersianNum('12'),
            '12:30 - 13:00' => $this->toPersianNum('12/5'),
            '13:00 - 13:30' => $this->toPersianNum('13'),
            '13:30 - 14:00' => $this->toPersianNum('13/5'),
            '14:00 - 14:30' => $this->toPersianNum('14'),
            '14:30 - 15:00' => $this->toPersianNum('14/5'),
            '15:00 - 15:30' => $this->toPersianNum('15'),
            '15:30 - 16:00' => $this->toPersianNum('15/5'),
            '16:00 - 16:30' => $this->toPersianNum('16'),
            '16:30 - 17:00' => $this->toPersianNum('16/5'),
            '17:00 - 17:30' => $this->toPersianNum('17'),
            '17:30 - 18:00' => $this->toPersianNum('17/5')
        ];
        $firstAthlete = null;
        $secondAthlete = null;
        $thirdAthlete = null;
        $start = 0;
        $end = 0;
        $count = 1;
        $found = null;
        $cancel = '';
        $slots = Slot::all();
        $slotsOfTheUser = Slot::where('athlete_id_1', $user->id)->orWhere('athlete_id_2', $user->id)->orWhere('athlete_id_3', $user->id)->get();
        if ($request->getMethod() == 'POST') {

            if ($request->input('time')) {
                $arr = explode('-', $request->input('time'));
                $start = trim($arr[0]);
                $end = trim($arr[1]);
            } else {
                $request->session()->flash("msg_error", "لطفا زمان موردنظر خود را انتخاب کنید.");
                return redirect()->back();
            }

            if ($request->input('date')) {
                $from_date = $this->jalaliToGregorian($request->input('date'));
            } else {
                $request->session()->flash("msg_error", "لطفا تاریخ موردنظر خود را انتخاب کنید.");
                return redirect()->back();
            }

            $found = Slot::where('start', $start)
                ->where('end', $end)
                ->where('date', $from_date)
                ->first();
            $foundTheLoginUser = Slot::where('start', $start)
                ->where('end', $end)
                ->where('date', $from_date)->where(function ($query) use ($user) {
                    $query->where('athlete_id_1', $user->id)->orWhere('athlete_id_2', $user->id)->orWhere('athlete_id_3', $user->id);
                })->first();

            if ($foundTheLoginUser) {
                $first = $foundTheLoginUser->athlete_id_1;
                $second = $foundTheLoginUser->athlete_id_2;
                $third = $foundTheLoginUser->athlete_id_3;
                if ($first == $user->id) {
                    $foundTheLoginUser->athlete_id_1 = 0;
                    $foundTheLoginUser->save();
                    $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
                    return redirect()->back();
                } else if ($second == $user->id) {
                    $foundTheLoginUser->athlete_id_2 = 0;
                    $foundTheLoginUser->save();
                    $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
                    return redirect()->back();
                } else if ($third == $user->id) {
                    $foundTheLoginUser->athlete_id_3 = 0;
                    $foundTheLoginUser->save();
                    $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
                    return redirect()->back();
                }
            }
            if (count($slotsOfTheUser) >= 2) {
                $sw = 1;
                $request->session()->flash("msg_error", "در ماه بیش تر از ۲ روز مجاز به وقت گرفتن نیستید!");
                return redirect()->back();
            }
            if ($found && !$sw) {
                $firstAthlete = $found->athlete_id_1;
                $secondAthlete = $found->athlete_id_2;
                $thirdAthlete = $found->athlete_id_3;
                $athletes = [$firstAthlete, $secondAthlete, $thirdAthlete];
                if (empty(array_filter($athletes))) {
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
                } else if (!empty(array_filter($athletes))) {
                    if (!$firstAthlete) {
                        $found->athlete_id_1 = $user->id;
                        $found->save();
                        $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                        return redirect()->back();
                    } else {
                        if (!$secondAthlete) {
                            $found->athlete_id_2 = $user->id;
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        }
                        if (!$thirdAthlete) {
                            $found->athlete_id_3 = $user->id;
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        }
                    }
                } else if ($firstAthlete != 0 && $secondAthlete == 0) {
                    $found->athlete_id_2 = Auth::user()->id;
                    try {
                        if ($firstAthlete != $found->athlete_id_2) {
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != 0 && $secondAthlete != 0 && $thirdAthlete == 0) {
                    $found->athlete_id_3 = Auth::user()->id;
                    try {
                        if ($firstAthlete != $found->athlete_id_3  && $secondAthlete !=  $found->athlete_id_3) {
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back();
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != 0 && $secondAthlete != 0 && $thirdAthlete != 0) {
                    $request->session()->flash("msg_error", "در این تایم نوبت ها پر شده است.");
                    return redirect()->back();
                }
            } else if (!$found && !$sw) {
                $slot = new Slot;
                $slot->start = $start;
                $slot->end = $end;
                $slot->date = $from_date;
                $slot->athlete_id_1 = Auth::user()->id;
                try {
                    $slot->save();
                    $count = 1;
                    $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                    return redirect()->back();
                } catch (Exception $e) {
                    dd($e);
                }
            }
        }
        foreach($slots as $slot){
            for($i = 0;$i < 20;$i++){
                $countAthleteArr[jdate($slot->date)->format('Y-m-d')][$i] = 0;
            }
        }
        foreach ($slots as $slot) {
            $slotsFoundByDate = Slot::where('date', $slot->date)->get();
            foreach ($slotsFoundByDate as $i => $item) {
                //if (count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]))) {
                $countAthleteArr[jdate($item->date)->format('Y-m-d')][$i] = count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]));
                //}
            }
        }
        $theUserSlots = [];
        for ($i = 1; $i <= 30; $i++) {
            $theUserSlots[jdate()->addDays($i - 1)->format('Y-m-d')] = [];
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
        foreach($slots as $item){
            $date = jdate($item->date)->format('Y-m-d');
            for($j =1; $j <= 20; $j++){
                $theUserSlots[$date]["slot-".$j] = ["is_mine" => null, "seat_count" => null];
            }
            $theUserSlots[$date]["is_mine"] = null;
        }
        foreach ($slots as $index => $item) {
            $date = jdate($item->date)->format('Y-m-d');
            $slotsFoundByDate = Slot::where('date', $item->date)->get();
            foreach ($slotsFoundByDate as $i => $s) {
                $theSwitch = Slot::where('date', $s->date)
                    ->where('start', $s->start)
                    ->where('end', $s->end)
                    ->where(function ($query) use ($user) {
                        $query->where('athlete_id_1', $user->id)
                            ->orWhere('athlete_id_2', $user->id)
                            ->orWhere('athlete_id_3', $user->id)
                            ->first();
                    })->first();
                $theSelf = $theSwitch != null ? 1 : 0;
                $theUserSlots[$date]["slot-".($slotIndex[$s->start])] = ["is_mine" => $theSelf, "seat_count" => $countAthleteArr[$date][$i]];
            }
            $theUserSlots[$date]["is_mine"] = 0;
        }
        foreach($theUserSlots as $x => $item){
            foreach($item as $y => $index){
               if(!empty($theUserSlots)){
                   if($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"]!= 0){
                        $theUserSlots[$x]["is_mine"] = $theUserSlots[$x][$y]["is_mine"];
                   }elseif($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"]== 0){
                        $theUserSlots[$x]["is_mine"] = 0;
                   }
               }
            }
        }

        $todayTime = jdate()->addDays(1)->format('H:i');
        return view('Athlete.dashboard')->with([
            'from_date' => $from_date,
            'arrOfTimes' => $arrOfTimes,
            'msg_success' => request()->session()->get('msg_success'),
            'msg_error' => request()->session()->get('msg_error'),
            'role' => $role->type,
            'user_slots' => $theUserSlots,
            'i' => $i,
            'sw' => $sw,
            'todayTime' => $todayTime,
            'count' => $countAthleteArr,
            'cancel' => $cancel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
