<?php

namespace Magein\Sms\Facades;

use Illuminate\Support\Facades\Facade;
use Magein\Sms\Lib\SmsResult;

/**
 * @method static $this  platform(string $platform)
 * @method static SmsResult  send($phone, string $message, array $replace = [])
 * @method static SmsResult  code($phone)
 * @method static SmsResult login($phone)
 * @method static SmsResult register($phone)
 * @method static SmsResult findPass($phone)
 */
class Sms extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}
