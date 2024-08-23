<?php

declare(strict_types=1);

namespace App\System\Model;

use HyperfAdminCore\Model;

/**
 * @property int $system_role_id 角色主键
 * @property int $system_menu_id 菜单主键
 */
class SystemRoleMenu extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_role_menu';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['system_role_id' => 'integer', 'system_menu_id' => 'integer'];
}
