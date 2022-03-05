<?php

namespace Magein\Sms\Lib;

class SmsResult
{
    /**
     * @var int
     */
    private $code = 0;

    /**
     * @var string
     */
    private $error = '';

    public function __construct($code = 0, $error = '')
    {
        $this->code = $code;
        $this->error = $error;
    }

    public function fail()
    {
        return $this->code !== 0;
    }

    public function error()
    {
        return $this->error;
    }

    public function code()
    {
        return $this->code;
    }
}
