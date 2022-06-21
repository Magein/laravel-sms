<?php

namespace Magein\Sms\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Magein\Sms\Facades\Sms;
use Magein\Sms\Lib\SmsCode;
use Magein\Sms\Lib\SmsOutput;

class SmsController
{
    /**
     * 这里 code=0 表示发生正常发送
     * @param SmsOutput $output
     * @return Application|ResponseFactory|Response
     */
    private function response(SmsOutput $output)
    {
        return response(['code' => $output->getCode(), 'msg' => $output->getMessage(), 'data' => $output->getData()]);
    }

    public function login(Request $request)
    {
        return $this->response(Sms::code($request::input('phone'), SmsCode::SCENE_LOGIN));
    }

    public function register(Request $request)
    {
        return $this->response(Sms::code($request::input('phone'), SmsCode::SCENE_REGISTER));
    }

    public function findPass(Request $request)
    {
        return $this->response(Sms::code($request::input('phone'), SmsCode::SCENE_VERIFY_PHONE));
    }
}
