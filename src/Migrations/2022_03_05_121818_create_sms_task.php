<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_task', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('任务创建人');
            $table->string('title', 30)->comment('任务名称');
            $table->string('description')->comment('任务描述')->default('');
            $table->string('content')->comment('短信内容');
            $table->string('replace')->comment('变量')->default('');
            $table->text('phone')->comment('手机号码');
            $table->dateTime('run_time')->comment('任务执行时间');
            $table->string('platform')->comment('使用平台 第三方短信运营平台名称')->default('');
            $table->integer('is_lock')->comment('是否锁定 防止重复执行')->default(0);
            $table->integer('total')->comment('总数')->default(0);
            $table->integer('success')->comment('成功数量')->default(0);
            $table->integer('fail')->comment('失败数量')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sms_task` comment '短信任务表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_task');
    }
}
