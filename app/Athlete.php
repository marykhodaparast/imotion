<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone'
    ];
    public function user(){
        return $this->belongsTo('App\User','athlete_id','id');
    }
    public function role(){
        return $this->hasOne('App\Role','id','role_id');
    }
}
