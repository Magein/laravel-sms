<?php

/**
 * 前端api请求接口
 *
 * 这里是控制器的概念，不需要重新写接口
 *
 * 防止盗链：
 *
 * 一般运营商已经加了防止盗链的功能，这里加也是锦上添加
 *
 * 比如：
 * 1. 同一个手机号码短时间内只能发送五次
 * 2. 允许某个ip请求（前后端分离的情况下，可以使用在config/cors.php中过滤）
 * 3. 这里只允许实现了发送验证码的路由
 *
 */

use Illuminate\Support\Facades\Route;
use Magein\Sms\Controllers\SmsController;

Route::prefix('sms')->group(function () {
    Route::post('code', [SmsController::class, 'code']);
    Route::post('login', [SmsController::class, 'login']);
    Route::post('register', [SmsController::class, 'register']);
    Route::post('findPass', [SmsController::class, 'findPass']);
});