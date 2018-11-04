<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('catagory')->comment('类别');
            $table->string('name')->comment('名称');
            $table->string('appid')->comment('appid');
            $table->string('secret')->comment('secret');
            $table->string('aes_key')->comment('aes_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_configs');
    }
}
