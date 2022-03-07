<?php

namespace Magein\Sms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $task_id
 * @property string $phone
 * @property string $platform
 * @property string $content
 * @property string $result
 * @property string $reason
 * @property string $send_time
 */
class SmsQueue extends Model
{
    protected $fillable = [
        'task_id',
        'phone',
        'platform',
        'content',
        'result',
        'reason',
        'send_time',
    ];
}
