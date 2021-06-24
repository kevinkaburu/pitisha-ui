<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forex extends Model
{
    protected $table = 'forex';
    protected $primaryKey = 'forex_id';
    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'modified';

    public function usd_rate()
    {
        return $this->usd - $this->pitisha;
    }
}
