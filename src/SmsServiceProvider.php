<?php

namespace Magein\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 加载函数
        if (is_file(__DIR__ . '/Common.php')) {
            require_once __DIR__ . '/Common.php';
        }

        $this->mergeConfigFrom(__DIR__ . '/Config.php', 'sms');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 注册发送验证码路由
        $path = __DIR__ . '/Router.php';
        $this->loadRoutesFrom($path);

        // 加载数据库迁移文件
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }
}
