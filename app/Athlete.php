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
        return $this->belongsTo('App\User','id','athlete_id');
    }
    public function role(){
        return $this->hasOne('App\Role','id','role_id');
    }
}
