<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_template', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('模板创建人');
            $table->string('title', 30)->comment('模板名称');
            $table->string('content')->comment('模板内容');
            $table->string('replace')->comment('变量')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_template');
    }
}
