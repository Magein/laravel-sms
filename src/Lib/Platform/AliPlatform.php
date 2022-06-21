<?php

namespace Magein\Sms\Lib\Platform;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Magein\Sms\Lib\SmsOutput;
use Darabonba\OpenApi\Models\Config;

class AliPlatform extends SmsPlatform
{
    /**
     * @var string
     */
    protected string $template_code = '';

    /**
     * @return string
     */
    public function name(): string
    {
        return config('sms.ali.name') ?: 'ali';
    }

    /**
     * @param string $code
     * @return void
     */
    public function templateCode(string $code = '')
    {
        $this->template_code = $code;
    }

    /**
     * @return Dysmsapi
     */
    private function client(): Dysmsapi
    {
        $sms_config = config('sms.ali');
        $config = new Config([
            'accessKeyId' => $sms_config['access_key_id'],
            'accessKeySecret' => $sms_config['access_key_secret']
        ]);
        $config->endpoint = $sms_config['endpoint'];
        return new Dysmsapi($config);
    }

    /**
     * 阿里云发送短信，需要执行template_code
     * 且短信内容值编辑好的只需要替换变量
     *
     * 如：验证码：${code}，${expired_at}分钟内有效。如非本人操作请忽略
     *
     * 最后templateParam参数应该是一个字符串 {code:123,expired_at:1800}
     *
     * @param $phone
     * @param $message
     * @param $replace
     * @return SmsOutput
     */
    public function send($phone, $message, $replace = []): SmsOutput
    {
        $signature = config('sms.ali.signature') ?: config('sms.ali.default');

        $template_code = $this->template_code;
        if (!$template_code) {
            $template_code = config('sms.ali.code');
        }
        $template = config('sms.ali.template');
        $variable = $template[$template_code] ?? [];
        $message = '';
        if (is_array($variable)) {
            foreach ($variable as $item) {
                $value = $replace[$item] ?? '';
                if ($value) {
                    $message .= "$item:$value,";
                }
            }
        }

        if ($message) {
            $message = trim($message, ',');
            $message = '{' . $message . '}';
        }

        $request = new SendSmsRequest();
        $request->phoneNumbers = $phone;
        $request->signName = $signature;
        $request->templateCode = $template_code;
        $request->templateParam = $message;

        try {
            $response = $this->client()->sendSms($request);
            $body = $response->body->toMap();
            if ($body['Code'] != 'ok') {
                $result = new SmsOutput($body['Message']);
            } else {
                $result = SmsOutput::success($body);
            }
        } catch (TeaUnableRetryError $exception) {
            $result = new SmsOutput('阿里云发送失败：' . $exception->getMessage(), $exception->getCode());
        }

        return $result;
    }
}
