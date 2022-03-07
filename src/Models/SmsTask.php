<?php

namespace Magein\Sms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $replace
 * @property string $phone
 * @property string $run_time
 * @property string $platform
 * @property string $is_lock
 * @property string $total
 * @property string $success
 * @property string $fail
 */
class SmsTask extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'replace',
        'phone',
        'run_time',
        'platform',
        'is_lock',
        'total',
        'success',
        'fail',
    ];
}
