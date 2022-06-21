<?php

namespace Magein\Sms\Lib;

class SmsOutput
{
    /**
     * @var int
     */
    protected int $code = 1;

    /**
     * @var string
     */
    protected string $message = '';

    /**
     * @var mixed|null
     */
    protected $data = null;

    /**
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function fail(): bool
    {
        return $this->code !== 0;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed|null $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param $data
     * @param string $message
     * @return \Magein\Sms\Lib\SmsOutput
     */
    public static function success($data = null, string $message = ''): SmsOutput
    {
        $instance = new self();

        $instance->data = $data;
        $instance->code = 1;
        $instance->message = $message;

        return $instance;
    }
}
