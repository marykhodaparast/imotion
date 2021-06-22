<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlotCreateRequest;
use App\Slot;
use App\Utils\PersianUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SlotController extends Controller
{

    protected $num_day;
    public function __construct()
    {
        $this->num_day = Config::get('constants.options.num_day');
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
     * @return \Illuminate\Http\Response
     */
    public function create(SlotCreateRequest $request)
    {

        $sw = 0;
        $start = null;
        $end = null;
        $from_date = null;
        $user = Auth::user();
        $user_id = $user->id;
        $englishDates = [];
        $error_message = null;
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
        if ($sw) {
            $x = Carbon::now()->format('Y-m-d H:i');
            //$x = "2021-06-26 12:35";
            $y = $from_date . " " . $time1;
            $diff = abs(strtotime($y) - strtotime($x));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
            $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
            $hours = $days*24 + $hours;
            $error_message = "salam";
            if($hours > 48 || ($hours == 48 && $minuts > 0)){
               $error_message = "یک کارت زرد گرفتید"; 
            } 
        }
        try {
            if(!$sw) {
                $found->save();
                $request->session()->flash("msg_success", $message);
            } else if($sw) {
                if($error_message != null) {
                    $request->session()->flash("msg_error", $error_message);
                }
            }
            return redirect()->back();
        } catch (Exception $e) {
            $this->checkEnv($e);
        }
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
}
