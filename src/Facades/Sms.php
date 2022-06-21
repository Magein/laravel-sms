<?php

namespace Magein\Sms\Facades;

use Illuminate\Support\Facades\Facade;
use Magein\Sms\Lib\SmsOutput;

/**
 * @method static $this  platform(string $platform)
 * @method static SmsOutput  send($phone, string $message, array $replace = [])
 * @method static SmsOutput  code(string $phone = '', string $scene = 'verify')
 * @method static SmsOutput  validate(string $phone = '', $code = '', string $scene = '')
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
