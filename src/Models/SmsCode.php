<?php

namespace Magein\Sms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 * @property string $scene
 * @property string $phone
 * @property string $code
 * @property string $expired_at
 * @property string $ip
 */
class SmsCode extends Model
{
    protected $fillable = [
        'key',
        'scene',
        'phone',
        'code',
        'expired_at',
        'ip',
    ];
}
