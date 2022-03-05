<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsQueueHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_queue_history', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->comment('任务ID');
            $table->char('phone', 11)->comment('手机号码');
            $table->string('platform')->comment('使用平台')->default('');
            $table->string('content')->comment('短信内容')->default('');
            $table->string('result')->comment('结果');
            $table->string('reason')->comment('原因')->default('');
            $table->dateTime('send_time')->comment('发送时间')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sms_queue_history` comment '待发短信队列历史记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_queue_history');
    }
}
