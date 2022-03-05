<?php

if (!function_exists('readPhoneNumbers')) {
    /**
     * 读取手机号码
     *
     * 提取规则 ： 1开始的连续的11位数字
     *
     * 1.支持文件读取 csv 以及 txt 需要是一列一列的
     * 如：
     * 手机号码
     * 15956946055
     * 15956946054
     * 15956946053
     * 15956946052
     * 15956946051
     * 不支持excel是因为需要依赖插件，实际过程中使用excel的话，可以在桌面打开另存为即可
     *
     * 2.支持从字符串中提取 15956946055 1595694  15956946053 , |qqw 15956946053 15956946057a12123a1595694605a2
     * @param string $filepath
     * @return array|mixed
     */
    function readPhoneNumbers(string $filepath)
    {
        $phones = [];
        if (is_file($filepath)) {
            $format = 'UTF-8';
            $res = fopen($filepath, 'r+');
            $data = fread($res, filesize($filepath));
            $from = mb_detect_encoding($data);
            if ($from === false) {
                $data = mb_convert_encoding($data, $format);
            } elseif ($from !== $format) {
                $data = mb_convert_encoding($data, $format, $from);
            }
            $array = explode("\n", $data);
            if (is_array($array)) {
                foreach ($array as $item) {
                    preg_match_all('/[0-9]?/', $item, $matches);
                    $number = array_filter($matches[0] ?? [], function ($value) {
                        return !($value === '');
                    });
                    if (empty($number)) {
                        continue;
                    }
                    $number = implode('', $number);
                    if (!preg_match('/^1[0-9]{10}/', $number)) {
                        continue;
                    }
                    $phones[] = $number;
                }
            }
        } else {
            preg_match_all('/1[0-9]{10}/', $filepath, $matches);
            $phones = $matches[0] ?? [];
        }
        return array_unique($phones);
    }
}