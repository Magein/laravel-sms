### 简介

> laravel项目中使用的短信平台

目前之集成了阿里云的，后续会支持梦网平台、以及各大厂牌的

### 安装

```angular2html
composer require magein/laravel-sms:*@dev -vvv -o
```

### 注册服务提供者

在config/app.php中注册服务提供者,并且添加Sms的facades

```php
$providers=[
    // 此处省略其他的服务提供者
    Magein\Sms\SmsServiceProvider::class
];
```

### 发送 && 验证

```php
// 发送验证码
Magein\Sms\Facades\Sms::code($phone);
Magein\Sms\Facades\Sms::login($phone);
Magein\Sms\Facades\Sms::register($phone);
Magein\Sms\Facades\Sms::findPass($phone);
// 发送短信 手机号码 短信内容 内容里面的变量
Magein\Sms\Facades\Sms::send($phone,$message,$replace);

// 指定平台,平台需要继承 \Magein\Sms\Lib\Platform\SmsPlatform 抽象类
Magein\Sms\Facades\Sms::platform(\Magein\Sms\Lib\Platform\AliPlatform::class)->send();

// 不传递参数将从自动使用request()->input('phone');request()->input('code')
\Magein\Sms\Lib\SmsCode::validate();
// 传递场景值(login、register、findPass)等场景,phone、code自动获取
\Magein\Sms\Lib\SmsCode::validate($scene);
// 传递全部参数
\Magein\Sms\Lib\SmsCode::validate($scene,$phone,$code);

```

### 配置文件

src/Config.php中提供了配置文件，需要修改可以在项目的config目录下新增sms.php

```php
return [
    'default' => [
        // 使用的驱动，支持 db、redis、session，默认db
        'driver' => 'db',
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
]
```

### api请求发送验证码

> 后端无需实现此接口，注册服务提供者后，会自动调用src/Router路由文件

```
request
{
    url:"http://host.com/sms/code",
    method:"post",
    data:{
        phone:"",
        code:'',
    }
}

response
{
    code:0,
    msg:'发送成功',
    data:{
       code:0, // 实际发送的结果
       error:'' // 原因
    }
}
```

> code始终为0，原因是不管是短信欠费，或者是其他原因，给用户的的反馈就是发送了，data中是实际的发送结果，如果需要请使用data中的参数判断

### 批量发送

> 今天大部分运营商都提供了批量发送的接口，项目中不提供批量发送的接口

实现：

1. 创建任务，包含任务名称，短信内容、发送时间、目标号码
2. 开启定时任务检测是否有批量发送的内容
3. 加入到队列中
4. 发送结果可监控（在项目中，而不是去登录运营商平台）

提供的函数
```php
// 提取手机号码,可以传递字符串，可以传递一个文件
readPhoneNumbers($filepath);
```




