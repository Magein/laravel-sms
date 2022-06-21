<?php

namespace Magein\Sms\Lib;

use Magein\Sms\Lib\Platform\SmsPlatform;
use magein\tools\common\RegVerify;
use function config;

class Sms
{
    /**
     * @var string
     */
    private string $platform = '';

    /**
     * @param string $platform
     * @return \Magein\Sms\Lib\Sms
     */
    public function platform(string $platform): Sms
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @param string|int $phone 手机号码
     * @param string $message 短信内容  变量的格式 ${string}
     * @param array $replace 短信内容中需要替换的变量
     * @return SmsOutput
     */
    public function send($phone, string $message, array $replace = []): SmsOutput
    {
        $platform = $this->platform ?: config('sms.default.platform');

        try {
            $platform = new $platform();
        } catch (\Exception $exception) {
            $platform = null;
        }

        if (empty($platform) || !$platform instanceof SmsPlatform) {
            return new SmsOutput('初始化短信平台异常');
        }

        return $platform->send($phone, $message, $replace);
    }

    /**
     * @param string $phone
     * @param string $scene
     * @return \Magein\Sms\Lib\SmsOutput
     */
    public function code(string $phone = '', string $scene = SmsCode::SCENE_VERIFY_PHONE): SmsOutput
    {
        $phone = $phone ?: request()->input('phone');
        if (empty($phone) || !RegVerify::phone($phone)) {
            return new SmsOutput('手机号码错误');
        }

        $config = config('sms.code');
        $scene = $scene ?: SmsCode::SCENE_VERIFY_PHONE;
        $template = $config['scene'][$scene] ?: $config['scene'][SmsCode::SCENE_VERIFY_PHONE];
        $expired_at = $config['expired_at'] ?? 1800;

        $code = (new SmsCode())->make($phone, $scene);
        $message = preg_replace(['/\${code}/', '/\${expired_at}/'], [$code, intval($expired_at / 60)], $template);
        $replace = [
            'code' => $code,
            'expired_at' => $expired_at,
        ];
        return $this->send($phone, $message, $replace);
    }

    /**
     * @param string $phone
     * @param string $code
     * @param string $scene
     * @return SmsOutput
     */
    public function validate(string $phone = '', string $code = '', string $scene = SmsCode::SCENE_VERIFY_PHONE): SmsOutput
    {
        return (new SmsCode())->validate($scene, $phone, $code);
    }
}
