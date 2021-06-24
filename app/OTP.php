<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'o_t_ps';

    protected $fillable = [
        'msisdn', 'otp', 'used',
    ];
}
