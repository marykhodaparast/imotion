<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
        'start',
        'end',
        'date',
        'athlete_id_1',
        'athlete_id_2',
        'athlete_id_3'
    ];

    public function first_athlete(){

        return $this->belongsTo('App\Athlete','athlete_id_1','id');
    }
    public function second_athlete(){
        return $this->belongsTo('App\Athlete','athlete_id_2','id');
    }
    public function third_athlete(){
        return $this->belongsTo('App\Athlete','athlete_id_3','id');
    }
}
