<?php

namespace Magein\Sms\Lib;

use Darabonba\GatewaySpi\Models\InterceptorContext\request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use function config;

class SmsCode
{

    // 验证手机号码
    const SCENE_VERIFY_PHONE = 'verify_phone';
    // 登录
    const SCENE_LOGIN = 'login';
    // 注册
    const SCENE_REGISTER = 'register';
    // 找回密码
    const SCENE_FINDPASS = 'find_pass';

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

    public function validate($scene = '', $phone = '', $code = '')
    {
        $scene = $scene ?: self::SCENE_VERIFY;
        $phone = $phone ?: request()->input('phone');
        $code = $code ?: request()->input('code');

        if (empty($phone)) {
            return new SmsResult(1, '请输入手机号码');
        }

        if (empty($code)) {
            return new SmsResult(1, '请输入验证码');
        }

        $driver = config('sms.default.driver');
        $key = $this->key($phone, $scene);
        if ($driver == 'db') {
            $smsCode = \Magein\Sms\Models\SmsCode::where('key', md5($phone . $code . $scene))->first();
            if (empty($smsCode)) {
                return new SmsResult(1, '验证码不正确');
            }
            if (now()->timestamp > Date::parse($smsCode->expired_at)->timestamp) {
                return new SmsResult(1, '验证码已经过期');
            }
            $res = $smsCode->code;
        } else {
            $res = Cache::store($driver === 'redis' ? 'redis' : 'file')->get($key);
            if (empty($res)) {
                return new SmsResult(1, '验证码已经过期');
            }
        }

        if ($code != $res) {
            return new SmsResult(1, '验证码不正确');
        }

        return new SmsResult();
    }

    /**
     * @param $phone
     * @param $code
     * @param $scene
     * @return false|mixed
     */
    public function write($phone, $code, $scene)
    {
        $driver = config('sms.default.driver');
        try {
            $result = call_user_func_array([static::class, $driver], [$phone, $code, $scene]);
        } catch (\Exception $exception) {
            $result = false;
        }
        return $result;
    }

    private function expire()
    {
        $expire = (int)config('sms.code.expired_at');
        if ($expire < 60) {
            $expire = 1800;
        }
        return $expire;
    }

    /**
     * @param $phone
     * @param $code
     * @param $scene
     * @return string
     */
    private function key($phone, $scene)
    {
        return 'sms_code_' . $scene . '_' . $phone;
    }

    /**
     * @param $phone
     * @param $code
     * @param $scene
     * @return bool
     */
    private function cache($phone, $code, $scene)
    {
        $result = true;
        try {
            Cache::put($this->key($phone, $scene), $code, now()->addSeconds($this->expire()));
        } catch (\Exception $exception) {
            $result = false;
        }
        return $result;
    }

    /**
     * @param $phone
     * @param $code
     * @param $scene
     * @return bool
     */
    private function redis($phone, $code, $scene)
    {
        $result = true;
        try {
            Cache::store('redis')->put($this->key($phone, $scene), $code);
        } catch (\Exception $exception) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $phone
     * @param $code
     * @param $scene
     * @return void
     */
    private function db($phone, $code, $scene)
    {
        $smsCode = new \Magein\Sms\Models\SmsCode();
        $smsCode->key = md5($phone . $code . $scene);
        $smsCode->scene = $scene;
        $smsCode->phone = $phone;
        $smsCode->code = $code;
        $smsCode->expired_at = now()->addSeconds($this->expire());
        $smsCode->ip = request()->ip();
        $smsCode->save();
    }
}
