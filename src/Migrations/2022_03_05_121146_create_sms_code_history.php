<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsCodeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_code_histories', function (Blueprint $table) {
            $table->id();
            $table->char('key')->comment('标记 用户验证发送次数');
            $table->char('scene')->comment('场景 发送验证码的场景');
            $table->char('phone')->comment('手机号码');
            $table->char('code')->comment('验证码');
            $table->timestamp('expired_at')->comment('过期时间')->nullable();
            $table->string('ip')->comment('请求IP');
            $table->timestamps();
            $table->softDeletes();
            $table->index('key');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sms_code_histories` comment '发送短信验证码历史记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_code_histories');
    }
}
