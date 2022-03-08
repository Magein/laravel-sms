<?php

namespace Magein\Sms\Facades;

use Illuminate\Support\Facades\Facade;
use Magein\Sms\Lib\SmsResult;

/**
 * @method static $this  platform(string $platform)
 * @method static SmsResult  send($phone, string $message, array $replace = [])
 * @method static SmsResult  code(string $phone = '')
 * @method static SmsResult  validate(string $phone = '', $code = '', string $scene = '')
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
