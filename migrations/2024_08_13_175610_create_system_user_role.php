<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemUserRole extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_user_role', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('系统用户与系统角色关联表');
            $table->addColumn('bigInteger', 'system_user_id', ['unsigned' => true, 'comment' => '用户ID']);
            $table->addColumn('bigInteger', 'system_role_id', ['unsigned' => true, 'comment' => '角色ID']);
            $table->primary(['system_user_id', 'system_role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user_role');
    }
}
