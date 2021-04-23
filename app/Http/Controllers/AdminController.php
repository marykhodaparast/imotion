<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\Slot;
use App\User;
use App\Utils\PersianUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function arrForComparingRepeatedItems($first, $second, $third)
    {
        $arr1 = [$first, $second, $third];
        $arr2 = array_filter($arr1);
        return $arr2;
    }
    /**
     * handle error
     *
     */
    public function handleError($arr, $request, $allRequests)
    {
        $sw = 1;
        if (count($arr) != count(array_unique($arr))) {
            $sw = 0;
            $request->session()->flash("msg_error", "حداقل ۲ مورد شبیه هم انتخاب شده اند.");
        }
        // else if ((!$allRequests[0] && !$allRequests[1] && !$allRequests[2])) {
        //     $sw = 0;
        //     $request->session()->flash("msg_error", "فیلدها خالی است.");
        // }
        return $sw;
    }
    public function giveSlotsOfSpecificDateAndTime($date, $time)
    {
        $arr = explode('-', $time);
        $start = trim($arr[0]);
        $end = trim($arr[1]);
        $persian_utils = new PersianUtils;
        $slot = SLot::where('is_deleted', 0)->where('start', $start)->where('end', $end)->where('date', $persian_utils->jalaliToGregorian($date))->first();
        if ($slot) {
            return [
                [$slot->first_athlete ? $slot->first_athlete->id : 0, $slot->first_athlete ? $slot->first_athlete->first_name . ' ' . $slot->first_athlete->last_name . '-' . $slot->first_athlete->phone : null],
                [$slot->second_athlete ? $slot->second_athlete->id : 0, $slot->second_athlete ? $slot->second_athlete->first_name . ' ' . $slot->second_athlete->last_name . '-' . $slot->second_athlete->phone : null],
                [$slot->third_athlete ? $slot->third_athlete->id : 0, $slot->third_athlete ? $slot->third_athlete->first_name . ' ' . $slot->third_athlete->last_name . '-' . $slot->third_athlete->phone : null],
            ];
        }
        return [];
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $from_date = null;
        $s = 0;
        $i = 1;
        $arrOfDays = [
            0 => 'ج',
            1 => 'ش',
            2 => 'ی',
            3 => 'د',
            4 => 'س',
            5 => 'چ',
            6 => 'پ'
        ];
        $showUsersInView = [
            1 => '<i class="fas fa-user accepted"></i><i class="far fa-user"></i><i class="far fa-user"></i>',
            2 => '<i class="fas fa-user accepted"></i><i class="fas fa-user accepted"></i><i class="far fa-user"></i>',
            3 => '<i class="fas fa-user danger"></i><i class="fas fa-user danger"></i><i class="fas fa-user danger"></i>'
        ];
        $noUser = ' <i class="far fa-user"></i><i class="far fa-user"></i><i class="far fa-user"></i>';
        $countAthleteArr = [];
        $arr = [];
        $persian_utils = new PersianUtils;
        $arrOfTimes = [
            '08:00 - 08:30' => $persian_utils->toPersianNum('8'),
            '08:30 - 09:00' => $persian_utils->toPersianNum('8/5'),
            '09:00 - 09:30' => $persian_utils->toPersianNum('9'),
            '09:30 - 10:00' => $persian_utils->toPersianNum('9/5'),
            '10:00 - 10:30' => $persian_utils->toPersianNum('10'),
            '10:30 - 11:00' => $persian_utils->toPersianNum('10/5'),
            '11:00 - 11:30' => $persian_utils->toPersianNum('11'),
            '11:30 - 12:00' => $persian_utils->toPersianNum('11/5'),
            '12:00 - 12:30' => $persian_utils->toPersianNum('12'),
            '12:30 - 13:00' => $persian_utils->toPersianNum('12/5'),
            '13:00 - 13:30' => $persian_utils->toPersianNum('13'),
            '13:30 - 14:00' => $persian_utils->toPersianNum('13/5'),
            '14:00 - 14:30' => $persian_utils->toPersianNum('14'),
            '14:30 - 15:00' => $persian_utils->toPersianNum('14/5'),
            '15:00 - 15:30' => $persian_utils->toPersianNum('15'),
            '15:30 - 16:00' => $persian_utils->toPersianNum('15/5'),
            '16:00 - 16:30' => $persian_utils->toPersianNum('16'),
            '16:30 - 17:00' => $persian_utils->toPersianNum('16/5'),
            '17:00 - 17:30' => $persian_utils->toPersianNum('17'),
            '17:30 - 18:00' => $persian_utils->toPersianNum('17/5'),
        ];
        $start = 0;
        $end = 0;
        //$d = 0;
        //$athletes = [];
        // $users = User::all();
        // foreach ($users as $user) {
        //     if ($user->role->type == 'athlete') {
        //         $athletes[] = $user;
        //     }
        // }
        $athletes = Athlete::where('is_deleted',false)->get();
        // foreach($athletes as $athlete){
        //     if($athlete->role->name == 'athlete'){
        //       $athletes[] = $athlete;
        //     }
        // }
        //$slots = Slot::where('is_deleted', 0)->where('athlete_id_1', '!=', 0)->orWhere('athlete_id_2', '!=', 0)->orWhere('athlete_id_3', '!=', 0)->get();
        $slots = Slot::where('is_deleted', 0)->get();
        if ($request->getMethod() == 'POST') {
            $theTime = $request->input('theTime');
            $theDate = $request->input('theDate');
            $theArray = $this->giveSlotsOfSpecificDateAndTime($theDate, $theTime);
            return [
                'data' => $theArray,
                'error' => 'error',
            ];
        }

        foreach ($slots as $slot) {
            for ($i = 0; $i < 20; $i++) {
                $countAthleteArr[jdate($slot->date)->format('Y-m-d')][$i] = 0;
            }
        }
        foreach ($slots as $slot) {
            $slotsFoundByDate = Slot::where('is_deleted', 0)->where('date', $slot->date)->get();
            foreach ($slotsFoundByDate as $i => $item) {
                //if (count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]))) {
                $countAthleteArr[jdate($item->date)->format('Y-m-d')][$i] = count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]));
                //}
            }
        }
        $theUserSlots = [];
        $arrOfDates = [];
        for ($i = 1; $i <= 7; $i++) {
            $theUserSlots[jdate()->addDays($i - 1)->format('Y-m-d')] = [];
            $arrOfDates[] = jdate()->addDays($i - 1)->format('Y-m-d');
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
        foreach ($slots as $item) {
            $date = jdate($item->date)->format('Y-m-d');
            if (in_array($date, $arrOfDates)) {
                for ($j = 1; $j <= 20; $j++) {
                    $theUserSlots[$date]["slot-" . $j] = ["seat_count" => null];
                }
            }
        }
        foreach ($slots as $index => $item) {
            $date = jdate($item->date)->format('Y-m-d');
            if (in_array($date, $arrOfDates)) {
                $slotsFoundByDate = Slot::where('is_deleted', 0)->where('date', $item->date)->get();
                foreach ($slotsFoundByDate as $i => $s) {
                    $theUserSlots[$date]["slot-" . ($slotIndex[$s->start])] = ["seat_count" => $countAthleteArr[$date][$i]];
                }
            }
        }
        return view('Admin.index')->with([
            'from_date' => $from_date,
            'arrOfTimes' => $arrOfTimes,
            'msg_success' => request()->session()->get('msg_success'),
            'msg_error' => request()->session()->get('msg_error'),
            'role' => $role->type,
            'user_slots' => $theUserSlots,
            'i' => $i,
            'athletes' => $athletes,
            'arrOfDays' => $arrOfDays,
            'showUsersInView' => $showUsersInView,
            'noUser' => $noUser
        ]);
    }
    public function saveNewSlot(Request $request)
    {

        $date = $request->input('date');
        $time = $request->input('time');
        $firstAthlete = $request->input('first_athlete');
        $secondAthlete = $request->input('second_athlete');
        $thirdAthlete = $request->input('third_athlete');
        $allRequests = [(int) $firstAthlete, (int) $secondAthlete, (int) $thirdAthlete];
        $arr_without_zeros = $this->arrForComparingRepeatedItems($allRequests[0], $allRequests[1], $allRequests[2]);
        $sw = $this->handleError($arr_without_zeros, $request, $allRequests);

        $arr = explode('-', $request->input('time'));
        $start = trim($arr[0]);
        $end = trim($arr[1]);
        $persian_utils = new PersianUtils;
        $slot = Slot::where('is_deleted', 0)->where('date', $persian_utils->jalaliToGregorian($date))->where('start', $start)->where('end', $end)->first();
        if ($slot == null && $sw) {
            $s = new Slot;
            $s->date = $persian_utils->jalaliToGregorian($date);
            $s->start = $start;
            $s->end = $end;
            if ($firstAthlete || $secondAthlete || $thirdAthlete) {
                $s->athlete_id_1 = $firstAthlete;
                $s->athlete_id_2 = $secondAthlete;
                $s->athlete_id_3 = $thirdAthlete;
                $s->save();
                $request->session()->flash("msg_success", "با موفقیت ثبت شد.");
            } else {
                $request->session()->flash("msg_error", "فیلدها خالی است.");
            }
            return redirect()->back();
        } else {
            if (!$firstAthlete && !$secondAthlete && !$thirdAthlete) {
                $slot->is_deleted = 1;
                $slot->save();
                $request->session()->flash("msg_success", "نوبت با موفقیت حذف شد.");
                return redirect()->back();
            }
        }

        if ($sw) {
            $slot->athlete_id_1 = $firstAthlete;
            $slot->athlete_id_2 = $secondAthlete;
            $slot->athlete_id_3 = $thirdAthlete;
            if ($slot->athlete_id_3 == 'null') {
                $slot->athlete_id_3 = 0;
            }
            $slot->save();
            $request->session()->flash("msg_success", "با موفقیت ثبت شد.");
            return redirect()->back();
        }
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
            'error' => 'error',
        ];
    }
    //-------------------------AJAX---------------------------//
    public function getAllSelects(Request $request)
    {

        $search = trim($request->search);
        if ($search == '') {
            $athletes = User::orderby('id', 'desc')->select('id', 'name', 'email')->where('role_id', 2)->get();
        } else {
            $athletes = User::select('id', 'name', 'email')->where('role_id', 2)->where(function ($query) use ($search) {
                $query->where("name", 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
            })->orderby('id', 'desc')->get();
        }
        $response = array();
        foreach ($athletes as $athlete) {
            $response[] = array(
                "id" => $athlete->id,
                "text" => $athlete->name . '-' . $athlete->email,
            );
        }
        $response[] = [
            "id" => 0,
            "text" => "-",
        ];
        return $response;
    }

}
