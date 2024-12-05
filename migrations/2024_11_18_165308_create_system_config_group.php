<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateSystemConfigGroup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_config_group', function (Blueprint $table) {
            $table->comment('系统配置分组表');
            $table->bigIncrements('id');
            $table->string('key', 50)->comment('系统配置分组项');
            $table->string('name', 50)->comment('系统配置分组名称');
            $table->tinyInteger('is_system')->comment('是否为系统分组');
            $table->timestamp('created_at')->comment('创建时间');
            $table->timestamp('updated_at')->comment('更新时间');
            $table->unique('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_config_group');
    }
}

;
