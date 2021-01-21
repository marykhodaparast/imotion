<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Morilog\Jalali\CalendarUtils;


class AthleteController extends Controller
{

    public static function persianToEnglishDigits($pnumber) {
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
    public static function jalaliToGregorian($pdate){
		$pdate = explode('/', AthleteController::persianToEnglishDigits($pdate));
		$date = "";
		if(count($pdate)==3){
			$y = (int)$pdate[0];
			$m = (int)$pdate[1];
			$d = (int)$pdate[2];
			if($d > $y)
			{
				$tmp = $d;
				$d = $y;
				$y = $tmp;
			}
			$y = (($y<1000)?$y+1300:$y);
			$gregorian = CalendarUtils::toGregorian($y,$m,$d);
			$gregorian = $gregorian[0]."-".$gregorian[1]."-".$gregorian[2];
		}
		return $gregorian;
	}
    public function takeTurn(Request $request){
        $from_date = null;
        $arrOfTimes = [
           '08:30 - 08:00',
           '09:00 - 08:30',
           '09:30 - 09:00',
           '10:00 - 09:30',
           '10:30 - 10:00',
           '11:00 - 10:30',
           '11:30 - 11:00',
           '12:00 - 11:30',
           '12:30 - 12:00',
           '13:00 - 12:30',
           '13:30 - 13:00',
           '14:00 - 13:30',
           '14:30 - 14:00',
           '15:00 - 14:30',
           '15:30 - 15:00',
           '16:00 - 15:30',
           '16:30 - 16:00',
           '17:00 - 16:30',
           '17:30 - 17:00',
           '18:00 - 17:30'
        ];
        return view('Athlete.takeTurn')->with([
            'from_date' => $from_date,
            'arrOfTimes' => $arrOfTimes
        ]);
        dd($request->getMethod());
        if($request->getMethod() == 'POST'){
            dd($request->all());
            if($request->input('from_date')){
                $from_date = $this->jalaliToGregorian(request()->input('from_date'));
                // if($from_date != '')
                //     $call->where('created_at', '>=', $from_date);
            }
            // return view('Athlete.takeTurn',[
            //   'from_date' => $from_date
            // ]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
