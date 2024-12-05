<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateSystemConfig extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_config', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统配置表');
            $table->bigIncrements('id')->comment('主键');
            $table->string('key', 50)->comment('系统配置项');
            $table->string('value', 1000)->comment('系统配置项');
            $table->integer('value_type')->default(1)->comment('配置项类型：1文本、2图片');
            $table->tinyInteger('is_system')->comment('是否为系统配置');
            $table->string('remark', 20)->comment('备注');
            $table->integer('system_group_id')->default(0)->comment('系统配置分组ID');
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
        Schema::dropIfExists('system_config');
    }
}

;
