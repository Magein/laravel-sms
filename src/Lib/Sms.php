<?php

namespace Magein\Sms\Lib;

use Magein\Sms\Lib\Platform\SmsPlatform;
use function config;

class Sms
{
    /**
     * @var string
     */
    private $platform = '';

    /**
     * @param string $platform
     * @return $this
     */
    public function platform(string $platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @param string|int $phone 手机号码
     * @param string $message 短信内容  变量的格式 ${string}
     * @param array $replace 短信内容中需要替换的变量
     * @return SmsResult|mixed
     */
    public function send($phone, string $message, array $replace = [])
    {
        $platform = $this->platform ?: config('sms.default.platform');

        try {
            $platform = new $platform();
        } catch (\Exception $exception) {
            $platform = null;
        }

        if (empty($platform) || !$platform instanceof SmsPlatform) {
            return new SmsResult(1, '短信平台异常');
        }

        return $platform->send($phone, $message, $replace);
    }

    /**
     * @param $phone
     * @return SmsResult
     */
    public function code($phone)
    {
        return $this->replaceCodeTemplate($phone, 'normal');
    }

    /**
     * @param $phone
     * @return SmsResult|mixed
     */
    public function login($phone)
    {
        return $this->replaceCodeTemplate($phone, 'login');
    }

    /**
     * @param $phone
     * @return SmsResult|mixed
     */
    public function register($phone)
    {
        return $this->replaceCodeTemplate($phone, 'register');
    }

    /**
     * @param $phone
     * @return SmsResult|mixed
     */
    public function findPass($phone)
    {
        return $this->replaceCodeTemplate($phone, 'find_pass');
    }

    /**
     * @param $phone
     * @param string $scene 场景
     * @return SmsResult|mixed
     */
    private function replaceCodeTemplate($phone, string $scene = '')
    {
        $code = (new SmsCode())->make($phone, $scene);
        $template = config('sms.code.scene.' . $scene);
        if (empty($template)) {
            $template = config('sms.code.scene.normal');
        }
        $expired_at = config('sms.code.expired_at');
        $message = preg_replace(['/\${code}/', '/\${expired_at}/'], [$code, intval($expired_at / 60)], $template);
        $replace = [
            'code' => $code,
            'expired_at' => $expired_at,
        ];
        return $this->send($phone, $message, $replace);
    }
}
