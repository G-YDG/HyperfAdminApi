<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemMenu extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_menu', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统菜单信息表');
            $table->bigIncrements('id')->comment('菜单ID');
            $table->addColumn('bigInteger', 'parent_id', ['unsigned' => true, 'comment' => '父级菜单ID']);
            $table->addColumn('string', 'level', ['length' => 500, 'comment' => '组级集合']);
            $table->addColumn('string', 'name', ['length' => 50, 'comment' => '菜单名称']);
            $table->addColumn('string', 'code', ['length' => 100, 'comment' => '菜单标识代码']);
            $table->addColumn('string', 'icon', ['length' => 50, 'comment' => '菜单图标'])->nullable();
            $table->addColumn('string', 'route', ['length' => 200, 'comment' => '路由地址'])->nullable();
            $table->addColumn('string', 'component', ['length' => 255, 'comment' => '组件路径'])->nullable();
            $table->addColumn('string', 'redirect', ['length' => 255, 'comment' => '跳转地址'])->nullable();
            $table->addColumn('smallInteger', 'status', ['default' => 1, 'comment' => '状态 (1正常 2停用)'])->nullable();
            $table->addColumn('smallInteger', 'hide_menu', ['default' => 1, 'comment' => '显示隐藏 (1显示 2隐藏)'])->nullable();
            $table->addColumn('smallInteger', 'sort', ['unsigned' => true, 'default' => 0, 'comment' => '排序'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
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
        Schema::dropIfExists('system_menu');
    }
}
