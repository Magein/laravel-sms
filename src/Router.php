<?php

/**
 * 发送短信使用的路由文件
 */

use Illuminate\Support\Facades\Route;
use Magein\Sms\Controllers\SmsController;

Route::prefix('sms')->group(function () {
    Route::get('login', [SmsController::class, 'login']);
    Route::get('register', [SmsController::class, 'register']);
    Route::get('findPass', [SmsController::class, 'findPass']);
});
