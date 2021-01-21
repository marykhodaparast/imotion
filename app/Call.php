<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    public function product(){
        return $this->hasOne('App\Product', 'id', 'products_id');
    }

    public function notice(){
        return $this->hasOne('App\Notice', 'id', 'notices_id');
    }

    public function student(){
        return $this->hasOne('App\Student', 'id', 'students_id');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'users_id');
    }

    public function callresult(){
        return $this->hasOne('App\CallResult', 'id', 'call_results_id');
    }

    public function recall(){
        return $this->hasOne('App\Call', 'id', 'calls_id');
    }
}
