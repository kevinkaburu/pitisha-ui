<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function provider()
    {
        return $this->belongsTo('App\Provider', 'provider_id');
    }

}
