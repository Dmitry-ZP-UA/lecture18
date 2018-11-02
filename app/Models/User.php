<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 02.11.18
 * Time: 16:22
 */

namespace App\Models;


use Illuminate\Support\Carbon;

class User
{
    /**
     * @var $username string
     */
    private $username;

    /**
     * @var $registerDatetime Carbon
     */
    private $registerDatetime;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return Carbon
     */
    public function getRegisterDatetime(): Carbon
    {
        return $this->registerDatetime;
    }

    /**
     * @param Carbon $registerDatetime
     */
    public function setRegisterDatetime(Carbon $registerDatetime): void
    {
        $this->registerDatetime = $registerDatetime;
    }
}
