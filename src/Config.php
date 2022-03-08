<?php

return [

    'default' => [
        /**
         * 使用的驱动
         * 支持 db、cache、redis
         * db：保存到sms_codes表中
         * redis：指定使用redis，cache默认使用文件，但是验证码想用redis驱动的情况
         * cache: 使用laravel的缓存系统
         */
        'driver' => 'cache',
        // 发送短信使用的平台
        'platform' => \Magein\Sms\Lib\Platform\AliPlatform::class,
        // 短信签名
        'signature' => '',
    ],

    /**
     * 阿里云的配置
     */
    'ali' => [
        // 平台名称
        'name' => 'ali',
        'access_key_id' => '',
        'access_key_secret' => '',
        'endpoint' => '',
        // 签名
        'signature' => '',
        // 模板列表
        'template' => [
            // key是模板编号 value是模板中的变量
            'SMS_205407022' => ['code'],
            'SMS_235812009' => ['name', 'account']
        ],
        // 发送验证码使用的模板
        'code' => 'SMS_205407022',
    ],

    /**
     * 手机短信验证码的配置信息
     * 使用场景：验证手机号码、登录、注册、找回密码等
     */
    'code' => [
        // 验证码长度，一般使用4位或者6位
        'length' => 4,
        // 有效期，单位秒
        'expired_at' => 1800,
        // 验证码使用的场景
        'scene' => [
            // 常规的验证手机
            'normal' => '验证码：${code}，请不要泄漏给其他人,${expired_at}分钟内有效。如非本人操作请忽略',
            // 登录
            'login' => '您本次登录校验码为:${code}，${expired_at}分钟内有效。如非本人操作请忽略',
            // 注册
            'register' => '注册验证码:${code}，请不要泄漏给其他人,${expired_at}分钟内有效。如非本人操作请忽略',
            // 找回密码
            'find_pass' => '您正在找回密码，验证码：${code}，请不要泄漏给其他人,${expired_at}分钟内有效。如非本人操作请忽略',
        ]
    ],
];
