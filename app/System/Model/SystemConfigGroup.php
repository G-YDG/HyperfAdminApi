<?php

declare(strict_types=1);

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\hasMany;
use HyperfAdminCore\Model;

/**
 * @property int $id
 * @property string $key 系统配置分组项
 * @property string $name 系统配置分组名称
 * @property int $is_system 是否为系统分组
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property-read null|Collection|SystemConfig[] $configs
 */
class SystemConfigGroup extends Model
{
    const IS_SYSTEM = 1;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_config_group';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'key', 'is_system', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'is_system' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 获取单前配置项的所以列表
     */
    public function configs(): hasMany
    {
        return $this->hasMany(SystemConfig::class, 'system_group_id', 'id');
    }
}
