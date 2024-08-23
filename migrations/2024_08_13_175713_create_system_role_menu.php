<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemRoleMenu extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_role_menu', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统角色与系统菜单关联表');
            $table->addColumn('bigInteger', 'system_role_id', ['unsigned' => true, 'comment' => '角色主键']);
            $table->addColumn('bigInteger', 'system_menu_id', ['unsigned' => true, 'comment' => '菜单主键']);
            $table->primary(['system_role_id', 'system_menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_role_menu');
    }
}
