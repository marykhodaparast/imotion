<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsValidation extends Model
{
    
    protected $fillable = [
        'mobile',
        'sms_code',
        'user_info'
    ];
}
