<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemRole extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_role', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统角色信息表');
            $table->bigIncrements('id')->comment('角色ID');
            $table->addColumn('string', 'name', ['length' => 30, 'comment' => '角色名称']);
            $table->addColumn('string', 'code', ['length' => 100, 'comment' => '角色代码']);
            $table->addColumn('smallInteger', 'status', ['default' => 1, 'comment' => '状态 (1正常 2停用)'])->nullable();
            $table->addColumn('smallInteger', 'sort', ['unsigned' => true, 'default' => 0, 'comment' => '排序'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_role');
    }
}
