<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Model;

use HyperfAdminCore\Model;

/**
 * @property int $system_user_id 用户ID
 * @property int $system_role_id 角色ID
 */
class SystemUserRole extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_user_role';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['system_user_id' => 'integer', 'system_role_id' => 'integer'];
}
