<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id');
    }


}
