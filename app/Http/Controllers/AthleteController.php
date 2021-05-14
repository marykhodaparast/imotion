<?php

namespace App\Http\Controllers;

use App\Http\Requests\AthleteCreateRequest;
use App\Slot;
use App\Utils\PersianUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Log;

class AthleteController extends Controller
{

    protected $num_day;
    public function __construct()
    {
        $this->num_day = Config::get('constants.options.num_day');
    }
    public static function showCssClass($slot_seat_count, $slot_is_mine, $is_mine)
    {
        $output = 'cursor_pointer hoverable';
        if ($slot_seat_count == null && $slot_is_mine == null && $is_mine == 1) {
            $output = 'text-lightgray';
        } else if ($slot_seat_count == 3 && $slot_is_mine != 1) {
            $output = '';
        }
        return $output;
    }
    /**
     * give UserSlots by to us by
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserSlots($slotIndex)
    {

        $user = Auth::user();
        $countAthleteArr = [];
        $slots = Slot::where('is_deleted', false)->get();
        $englishDates = [];
        for ($i = 1; $i <= $this->num_day; $i++) {
            $englishDates[] = Carbon::now()->addDays($i - 1)->format('Y-m-d');
        }
        foreach ($slots as $slot) {
            for ($i = 0; $i < 16; $i++) {
                $countAthleteArr[jdate($slot->date)->format('Y-m-d')][$i] = 0;
            }
        }
        foreach ($slots as $slot) {
            $slotsFoundByDate = Slot::where('is_deleted', false)->where('date', $slot->date)->get();
            foreach ($slotsFoundByDate as $i => $item) {
                $countAthleteArr[jdate($item->date)->format('Y-m-d')][$i] = count(array_filter([$item->athlete_id_1, $item->athlete_id_2, $item->athlete_id_3]));
            }
        }
        $theUserSlots = [];
        $arrOfDates = [];
        for ($i = 1; $i <= $this->num_day; $i++) {
            $theUserSlots[jdate()->addDays($i - 1)->format('Y-m-d')] = [];
            $arrOfDates[] = jdate()->addDays($i - 1)->format('Y-m-d');
        }
        foreach ($slots as $item) {
            $date = jdate($item->date)->format('Y-m-d');
            if (in_array($date, $arrOfDates)) {
                for ($j = 1; $j <= 16; $j++) {
                    $theUserSlots[$date]["slot-" . $j] = ["is_mine" => null, "seat_count" => null];
                }
                $theUserSlots[$date]["is_mine"] = null;
            }
        }
        foreach ($slots as $index => $item) {
            $date = jdate($item->date)->format('Y-m-d');
            if (in_array($date, $arrOfDates)) {
                $slotsFoundByDate = Slot::where('is_deleted', false)->where('date', $item->date)->get();
                foreach ($slotsFoundByDate as $i => $s) {
                    $theSwitch = Slot::where('is_deleted', false)->where('is_deleted', false)->where('date', $s->date)
                        ->where('start', $s->start)
                        ->where('end', $s->end)
                        ->where(function ($query) use ($user) {
                            $query->where('athlete_id_1', $user->id)
                                ->orWhere('athlete_id_2', $user->id)
                                ->orWhere('athlete_id_3', $user->id)
                                ->first();
                        })->first();
                    $theSelf = $theSwitch != null ? 1 : 0;
                    if(isset($slotIndex[$s->start])){
                        $theUserSlots[$date]["slot-" . ($slotIndex[$s->start])] = ["is_mine" => $theSelf, "seat_count" => $countAthleteArr[$date][$i]];
                    }
                }
                $theUserSlots[$date]["is_mine"] = 0;
            }
        }
        foreach ($theUserSlots as $x => $item) {
            foreach ($item as $y => $index) {
                if (!empty($theUserSlots)) {
                    if (is_array($theUserSlots[$x][$y])) {
                        if ($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"] != 0) {
                            $theUserSlots[$x]["is_mine"] = $theUserSlots[$x][$y]["is_mine"];
                        } elseif ($theUserSlots[$x][$y]["is_mine"] != null && $theUserSlots[$x][$y]["is_mine"] == 0) {
                            $theUserSlots[$x]["is_mine"] = 0;
                        }
                    }
                }
            }
        }
        return [$theUserSlots, $countAthleteArr];
    }
    /**
     * ajax for direct table to left
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxTableLeft(Request $request)
    {

        $persianUtils = new PersianUtils;
        $slotIndex = [
            "10:00:00" => 1,
            "10:30:00" => 2,
            "11:00:00" => 3,
            "11:30:00" => 4,
            "12:00:00" => 5,
            "12:30:00" => 6,
            "13:00:00" => 7,
            "13:30:00" => 8,
            "14:00:00" => 9,
            "14:30:00" => 10,
            "15:00:00" => 11,
            "15:30:00" => 12,
            "16:00:00" => 13,
            "16:30:00" => 14,
            "17:00:00" => 15,
            "17:30:00" => 16,
        ];
        $arrOfTimes = [
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
            '17:30 - 18:00' => $persianUtils->toPersianNum('17/5'),
        ];
        $arrOfTimeInView = [];
        foreach ($arrOfTimes as $key => $item) {
            $arrOfTimeInView[] = explode(' - ', $key);
        }
        $theUserSlots = $this->getUserSlots($slotIndex)[0];
        return [$arrOfTimes, $theUserSlots];

    }
    /**
     * ajax for direct table to right
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxTableRight(Request $request)
    {

        $persianUtils = new PersianUtils;
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
        ];
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
        ];
        $arrOfTimeInView = [];
        foreach ($arrOfTimes as $key => $item) {
            $arrOfTimeInView[] = explode(' - ', $key);
        }
        $theUserSlots = $this->getUserSlots($slotIndex)[0];
        return [$arrOfTimes, $theUserSlots];

    }
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
        $persianUtils = new PersianUtils;
        $showUsersInView = [
            1 => '<i class="fas fa-user accepted"></i><i class="far fa-user"></i><i class="far fa-user"></i>',
            2 => '<i class="fas fa-user accepted"></i><i class="fas fa-user accepted"></i><i class="far fa-user"></i>',
            3 => '<i class="fas fa-user danger"></i><i class="fas fa-user danger"></i><i class="fas fa-user danger"></i>',
        ];
        $noUser = ' <i class="far fa-user"></i><i class="far fa-user"></i><i class="far fa-user"></i>';
        $arrOfDays = [
            0 => 'ج',
            1 => 'ش',
            2 => 'ی',
            3 => 'د',
            4 => 'س',
            5 => 'چ',
            6 => 'پ',
        ];
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
        ];
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
        ];
        $theUserSlots = $this->getUserSlots($slotIndex)[0];
        $countAthleteArr = $this->getUserSlots($slotIndex)[1];
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
            'arrOfDays' => $arrOfDays,
            'showUsersInView' => $showUsersInView,
            'noUser' => $noUser,
        ]);
    }
    public function checkEnv($e)
    {

        if (env('APP_ENV') == 'development') {
            Log::info('failed ' . $e);
        } else if (env('APP_ENV') == 'production') {
            Log::info('failed');
        }
    }
    public function checkError($condition, $message, $request)
    {

        $output = 0;
        if ($condition) {
            $output = 1;
            $request->session()->flash("msg_error", $message);
        }
        return $output;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Http\Requests\AthleteCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(AthleteCreateRequest $request)
    {

        $sw = 0;
        $start = null;
        $end = null;
        $from_date = null;
        $user = Auth::user();
        $user_id = $user->id;
        $englishDates = [];
        for ($i = 1; $i <= $this->num_day; $i++) {
            $englishDates[] = Carbon::now()->addDays($i - 1)->format('Y-m-d');
        }
        $slotsOfTheUser = Slot::where('is_deleted', false)->where(function ($query) use ($user_id) {
            $query->where('athlete_id_1', $user_id)
                ->orWhere('athlete_id_2', $user_id)
                ->orWhere('athlete_id_3', $user_id);
        })->whereIn('date', $englishDates)->get();
        $time1 = $request->input('time1');
        $time2 = $request->input('time2');
        $date = $request->input('date');
        $start = $time1;
        $end = $time2;
        $persianUtils = new PersianUtils;
        $from_date = $date ? $persianUtils->jalaliToGregorian($date) : null;
        $found = Slot::where('is_deleted', false)->where('start', $start)
            ->where('end', $end)
            ->where('date', $from_date)
            ->where(function ($query) use ($user_id) {
                $query->where('athlete_id_1', '!=', strval($user_id))->orWhere('athlete_id_2', '!=', strval($user_id))->orWhere('athlete_id_3', '!=', strval($user_id));
            })->first();
        $foundByStartAndDateAndEnd = Slot::where('is_deleted', false)->where('start', $start)
            ->where('end', $end)
            ->where('date', $from_date)
            ->first();
        if (!$found) {
            $found = new Slot;
            $found->start = $start;
            $found->end = $end;
            $found->date = $from_date;
            $found->athlete_id_1 = $user_id;
            $found->athlete_id_2 = 0;
            $found->athlete_id_3 = 0;
        } else {
            $indx = 1;
            for ($i = 1; $i < 4; $i++) {
                if ($found->{"athlete_id_" . $i} == $user->id) {
                    $found->{"athlete_id_" . $i} = 0;
                    $sw = 1;
                }
            }
            if (!$sw) {
                while ($found->{"athlete_id_" . $indx} != 0 && $indx <= 3) {
                    $indx++;
                }
                $found->{"athlete_id_" . $indx} = $user_id;
            }
        }
        if (!$sw && $found) {
            $out1 = $this->checkError(count($slotsOfTheUser) >= 2, "در ماه بیش تر از دو روز مجاز به وقت گرفتن نیستید!", $request);
            $out2 = $this->checkError($foundByStartAndDateAndEnd && $foundByStartAndDateAndEnd->athlete_id_1 && $foundByStartAndDateAndEnd->athlete_id_2 && $foundByStartAndDateAndEnd->athlete_id_3, "در این تایم نوبت ها پر شده است.", $request);
            if ($out1 || $out2) {
                return redirect()->back();
            }
        }
        $message = $sw ? "با موفقیت حذف شدید" : "با موفقیت ثبت شدید";
        try {
            $found->save();
            $request->session()->flash("msg_success", $message);
            return redirect()->back();
        } catch (Exception $e) {
            $this->checkEnv($e);
        }
    }
}
