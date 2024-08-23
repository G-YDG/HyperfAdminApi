<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemUser extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_user', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统用户信息表');
            $table->bigIncrements('id')->comment('用户ID');
            $table->addColumn('string', 'username', ['length' => 20, 'comment' => '用户名']);
            $table->addColumn('string', 'password', ['length' => 100, 'comment' => '密码']);
            $table->addColumn('string', 'nickname', ['length' => 30, 'comment' => '用户昵称'])->nullable();
            $table->addColumn('string', 'phone', ['length' => 11, 'comment' => '手机'])->nullable();
            $table->addColumn('string', 'email', ['length' => 50, 'comment' => '用户邮箱'])->nullable();
            $table->addColumn('string', 'avatar', ['length' => 255, 'comment' => '用户头像'])->nullable();
            $table->addColumn('smallInteger', 'status', ['default' => 1, 'comment' => '状态 (1正常 2停用)'])->nullable();
            $table->addColumn('ipAddress', 'login_ip', ['comment' => '最后登陆IP'])->nullable();
            $table->addColumn('timestamp', 'login_time', ['comment' => '最后登陆时间'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->unique(['username', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user');
    }
}
