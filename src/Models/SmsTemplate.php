<?php

namespace Magein\Sms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $replace
 */
class SmsTemplate extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'replace',
    ];
}
