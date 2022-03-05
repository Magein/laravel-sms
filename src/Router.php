<?php

/**
 * 发送短信使用的路由文件
 */

use Illuminate\Support\Facades\Route;
use Magein\Sms\Controllers\SmsController;

Route::prefix('sms')->group(function () {
    Route::post('code', [SmsController::class, 'code']);
    Route::post('login', [SmsController::class, 'login']);
    Route::post('register', [SmsController::class, 'register']);
    Route::post('findPass', [SmsController::class, 'findPass']);
});