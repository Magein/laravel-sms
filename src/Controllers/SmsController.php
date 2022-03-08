<?php

namespace Magein\Sms\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Magein\Sms\Facades\Sms;
use Magein\Sms\Lib\SmsCode;
use Magein\Sms\Lib\SmsResult;

class SmsController
{
    /**
     * 这里 code=0 表示发生正常发送
     * @param SmsResult $result
     * @return Application|ResponseFactory|Response
     */
    private function response(SmsResult $result)
    {
        return response(['code' => $result->code(), 'msg' => $result->error(), 'data' => null]);
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
        return $this->response(Sms::code($request::input('phone'), SmsCode::SCENE_FINDPASS));
    }
}
