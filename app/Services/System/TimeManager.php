<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 02.11.18
 * Time: 16:19
 */

namespace App\Services\System;


use Illuminate\Support\Carbon;

class TimeManager
{
    public function getTime(): Carbon
    {
        return Carbon::now();
    }
}
