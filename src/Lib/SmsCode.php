<?php

namespace Magein\Sms\Lib;

use function config;

class SmsCode
{
    /**
     * @param string
     * @return int
     */

    /**
     * @param string|int $phone 手机号码
     * @param string $scene 验证码使用的场景
     * @return int
     */
    public function make($phone, string $scene = '')
    {
        $length = config('sms.code.length');

        $first = str_pad('1', $length, '0');
        $second = str_pad('9', $length, '9');
        $code = rand($first, $second);

        $this->write($phone, $code, $scene);

        return $code;
    }

    public function write($phone, $code, $scene)
    {

    }

    public static function validate($scene = '', $phone = '', $code = '')
    {

    }
}
