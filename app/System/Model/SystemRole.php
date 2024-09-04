<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsToMany;
use HyperfAdminCore\Model;

/**
 * @property int $id 角色ID
 * @property string $name 角色名称
 * @property string $code 角色代码
 * @property int $status 状态 (1正常 2停用)
 * @property int $sort 排序
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class SystemRole extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_role';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'code', 'status', 'sort', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'status' => 'integer', 'sort' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表获取菜单.
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(SystemMenu::class, 'system_role_menu', 'system_role_id', 'system_menu_id');
    }

    /**
     * 通过中间表获取用户.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(SystemUser::class, 'system_user_role', 'system_role_id', 'system_user_id');
    }
}
