<?php

namespace Magein\Sms\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Magein\Sms\Facades\Sms;
use Magein\Sms\Lib\SmsResult;

class SmsController
{
    /**
     * 这里 code=0 表示发生正常 使用定值是因为接口是对外部用户的，理应对用户显示已发送
     * @param SmsResult $result
     * @return Application|ResponseFactory|Response
     */
    private function response(SmsResult $result)
    {
        return response(['code' => 0, 'msg', 'data' => ['code' => $result->code(), 'error' => $result->error()]]);
    }

    public function code(Request $request)
    {
        return $this->response(Sms::code($request::input('phone')));
    }

    public function login(Request $request)
    {
        return $this->response(Sms::login($request::input('phone')));
    }

    public function register(Request $request)
    {
        return $this->response(Sms::register($request::input('phone')));
    }

    public function findPass(Request $request)
    {
        return $this->response(Sms::findPass($request::input('phone')));
    }
}