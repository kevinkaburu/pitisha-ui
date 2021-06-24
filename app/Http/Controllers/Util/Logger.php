<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 3/13/19
 * Time: 12:05 PM
 */

namespace App\Http\Controllers\Util;



namespace App\Http\Controllers\Util;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Logger
{
    public static function log($msg)
    {
        $log = date('Y-m-d H:i:s') . " | " . " Client IP: " . Request::ip() . " | " . $msg . "\n";
        Log::debug($log);

        //Logger::gcloudLog($title = 'debug', $log);
    }
}

