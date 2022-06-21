<?php

namespace Magein\Sms\Lib\Platform;

use Magein\Sms\Lib\SmsOutput;

abstract class SmsPlatform
{
    /**
     * 平台名称
     * @return string
     */
    abstract public function name(): string;

    /**
     * @param $phone
     * @param string $message
     * @param array $replace
     * @return SmsOutput
     */
    abstract public function send($phone, string $message, array $replace = []): SmsOutput;
}
