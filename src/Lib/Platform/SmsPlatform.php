<?php

namespace Magein\Sms\Lib\Platform;

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
     * @return mixed
     */
    abstract public function send($phone, string $message, array $replace = []);
}
