<?php

declare(strict_types=1);

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsToMany;
use HyperfAdminCore\Model;

/**
 * @property int $id 菜单ID
 * @property int $parent_id 父级菜单ID
 * @property string $level 组级集合
 * @property string $name 菜单名称
 * @property string $code 菜单标识代码
 * @property string $icon 菜单图标
 * @property string $route 路由地址
 * @property string $component 组件路径
 * @property string $redirect 跳转地址
 * @property int $status 状态 (1正常 2停用)
 * @property int $hide_menu 显示隐藏 (1显示 2隐藏)
 * @property int $sort 排序
 * @property string $remark 备注
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class SystemMenu extends Model
{

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_menu';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'id',
        'parent_id',
        'level',
        'name',
        'code',
        'icon',
        'route',
        'component',
        'redirect',
        'status',
        'hide_menu',
        'sort',
        'created_at',
        'updated_at',
        'remark',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'parent_id' => 'integer', 'status' => 'integer', 'hide_menu' => 'integer', 'sort' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表获取角色
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class, 'system_role_menu', 'system_menu_id', 'system_role_id');
    }
}
