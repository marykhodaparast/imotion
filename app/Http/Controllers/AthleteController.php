<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use App\Slot;
use App\Utils\PersianUtils;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $role = $user->role;
        $from_date = null;
        $i = 1;
        $sw = 0;
        $countAthleteArr = [];
        $persianUtils = new PersianUtils;
        $arrOfTimes = [
            '08:00 - 08:30' => $persianUtils->toPersianNum('8'),
            '08:30 - 09:00' => $persianUtils->toPersianNum('8/5'),
            '09:00 - 09:30' => $persianUtils->toPersianNum('9'),
            '09:30 - 10:00' => $persianUtils->toPersianNum('9/5'),
            '10:00 - 10:30' => $persianUtils->toPersianNum('10'),
            '10:30 - 11:00' => $persianUtils->toPersianNum('10/5'),
            '11:00 - 11:30' => $persianUtils->toPersianNum('11'),
            '11:30 - 12:00' => $persianUtils->toPersianNum('11/5'),
            '12:00 - 12:30' => $persianUtils->toPersianNum('12'),
            '12:30 - 13:00' => $persianUtils->toPersianNum('12/5'),
            '13:00 - 13:30' => $persianUtils->toPersianNum('13'),
            '13:30 - 14:00' => $persianUtils->toPersianNum('13/5'),
            '14:00 - 14:30' => $persianUtils->toPersianNum('14'),
            '14:30 - 15:00' => $persianUtils->toPersianNum('14/5'),
            '15:00 - 15:30' => $persianUtils->toPersianNum('15'),
            '15:30 - 16:00' => $persianUtils->toPersianNum('15/5'),
            '16:00 - 16:30' => $persianUtils->toPersianNum('16'),
            '16:30 - 17:00' => $persianUtils->toPersianNum('16/5'),
            '17:00 - 17:30' => $persianUtils->toPersianNum('17'),
            '17:30 - 18:00' => $persianUtils->toPersianNum('17/5')
        ];
        $cancel = '';
        $slots = Slot::all();
        $englishDates = [];
        for ($i = 1; $i <= 30; $i++) {
            $englishDates[] = Carbon::now()->addDays($i - 1)->format('Y-m-d');
        }
        //if ($request->getMethod() == 'POST') {


            // $found = Slot::where('start', $start)
            //     ->where('end', $end)
            //     ->where('date', $from_date)
            //     ->first();
            // if($found){
            //     if ($found->athlete_id_1 == $user->id || $found->athlete_id_2 == $user->id || $found->athlete_id_3 == $user->id) {
            //         $first = $found->athlete_id_1;
            //         $second = $found->athlete_id_2;
            //         $third = $found->athlete_id_3;
            //         if ($first == $user->id) {
            //             $found->athlete_id_1 = 0;
            //             $found->save();
            //             $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
            //             return redirect()->back();
            //         } else if ($second == $user->id) {
            //             $found->athlete_id_2 = 0;
            //             $found->save();
            //             $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
            //             return redirect()->back();
            //         } else if ($third == $user->id) {
            //             $found->athlete_id_3 = 0;
            //             $found->save();
            //             $request->session()->flash("msg_success", "با موفقیت حذف شدید.");
            //             return redirect()->back();
            //         }
            //     }
            // }
       // }
        foreach($slots as $slot){
            for($i = 0;$i < 20;$i++){
                $countAthleteArr[jdate($slot->date)->format('Y-m-d')][$i] = 0;
            }
        }
        foreach ($slots as $slot) {
            $slotsFoundByDate = Slot::where('date', $slot->date)->get();
            foreach ($slotsFoundByDate as $i => $item) {
                $countAthleteArr[jdate($item->date)->format('Y-m-d')][$i] = count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]));
            }
        }
        $theUserSlots = [];
        $arrOfDates = [];
        for ($i = 1; $i <= 30; $i++) {
            $theUserSlots[jdate()->addDays($i - 1)->format('Y-m-d')] = [];
            $arrOfDates[] = jdate()->addDays($i - 1)->format('Y-m-d');
        }
        //dd($arrOfDates);
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
            if(in_array($date,$arrOfDates)){
                for($j =1; $j <= 20; $j++){
                    $theUserSlots[$date]["slot-".$j] = ["is_mine" => null, "seat_count" => null];
                }
                $theUserSlots[$date]["is_mine"] = null;
            }
        }
        foreach ($slots as $index => $item) {
            $date = jdate($item->date)->format('Y-m-d');
            if(in_array($date,$arrOfDates)){
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
        }
        foreach($theUserSlots as $x => $item){
            foreach($item as $y => $index){
               if(!empty($theUserSlots)){
                    if(is_array($theUserSlots[$x][$y])){
                        if($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"]!= 0){
                            $theUserSlots[$x]["is_mine"] = $theUserSlots[$x][$y]["is_mine"];
                       }elseif($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"]== 0){
                            $theUserSlots[$x]["is_mine"] = 0;
                       }
                    }

               }
            }
        }
        $todayDate = jdate()->format('Y-m-d');
        $todayTime = jdate()->format('H:i');
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
            'todayDate' => $todayDate,
            'count' => $countAthleteArr,
            'cancel' => $cancel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sw = "create";
        $start = null;
        $end = null;
        $from_date = null;
        $user = Auth::user();
        $englishDates = [];
        for ($i = 1; $i <= 30; $i++) {
            $englishDates[] = Carbon::now()->addDays($i - 1)->format('Y-m-d');
        }
        $slotsOfTheUser = Slot::where(function($query) use($user){
           $query->where('athlete_id_1', $user->id)
           ->orWhere('athlete_id_2', $user->id)
           ->orWhere('athlete_id_3', $user->id);
        })->whereIn('date',$englishDates)->get();
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
                $persianUtils = new PersianUtils;
                $from_date = $persianUtils->jalaliToGregorian($request->input('date'));
            } else {
                $request->session()->flash("msg_error", "لطفا تاریخ موردنظر خود را انتخاب کنید.");
                return redirect()->back();
            }
            if (count($slotsOfTheUser) >= 2) {
                $request->session()->flash("msg_error", "در ماه بیش تر از ۲ روز مجاز به وقت گرفتن نیستید!");
                return redirect()->back();
            }
            $found = Slot::where('start', $start)
            ->where('end', $end)
            ->where('date', $from_date)
            ->first();
            if ($found) {
                $firstAthlete = $found->athlete_id_1;
                $secondAthlete = $found->athlete_id_2;
                $thirdAthlete = $found->athlete_id_3;
                $athletes = [$firstAthlete, $secondAthlete, $thirdAthlete];
                if (empty(array_filter($athletes))) {
                    $found->start = $start;
                    $found->end = $end;
                    $found->date = $from_date;
                    $found->athlete_id_1 = Auth::user()->id;
                    try {
                        $found->save();
                        $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                        return redirect()->back()->with([
                            'sw' => $sw
                          ]);;
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if (!empty(array_filter($athletes))) {
                    if (!$firstAthlete) {
                        $found->athlete_id_1 = $user->id;
                        $found->save();
                        $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                        return redirect()->back()->with([
                            'sw' => $sw
                          ]);;
                    } else {
                        if (!$secondAthlete) {
                            $found->athlete_id_2 = $user->id;
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back()->with([
                                'sw' => $sw
                              ]);;
                        }
                        if (!$thirdAthlete) {
                            $found->athlete_id_3 = $user->id;
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back()->with([
                                'sw' => $sw
                              ]);;
                        }
                    }
                } else if ($firstAthlete != 0 && $secondAthlete == 0) {
                    $found->athlete_id_2 = Auth::user()->id;
                    try {
                        if ($firstAthlete != $found->athlete_id_2) {
                            $found->save();
                            $request->session()->flash("msg_success", "با موفقیت ثبت شدید.");
                            return redirect()->back()->with([
                                'sw' => $sw
                              ]);;
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
                            return redirect()->back()->with([
                                'sw' => $sw
                              ]);;
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }
                } else if ($firstAthlete != 0 && $secondAthlete != 0 && $thirdAthlete != 0) {
                    $request->session()->flash("msg_error", "در این تایم نوبت ها پر شده است.");
                    return redirect()->back()->with([
                        'sw' => $sw
                      ]);;
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
                    return redirect()->back()->with([
                        'sw' => $sw
                      ]);;
                } catch (Exception $e) {
                    dd($e);
                }
            }


        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $sw = "destroy";
        //dd('destroy');
        if($request->getMethod() == "POST"){
            return view('Athlete.dashboard')->with([
                "sw" => $sw
            ]);
        }
    }
}
