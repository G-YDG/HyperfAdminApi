<?php

declare(strict_types=1);

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\hasOne;
use HyperfAdminCore\Model;

/**
 * @property int $id 主键
 * @property string $key 系统配置项
 * @property string $value 系统配置项
 * @property int $value_type 配置项类型：1文本、2图片
 * @property int $is_system 是否为系统配置
 * @property string $remark 备注
 * @property int $system_group_id 系统配置分组ID
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property-read null|SystemConfigGroup $group 
 */
class SystemConfig extends Model
{
    const IS_SYSTEM = 1;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_config';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'key', 'value', 'value_type', 'is_system', 'remark', 'system_group_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'value_type' => 'integer', 'is_system' => 'integer', 'system_group_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表获取角色.
     */
    public function group(): hasOne
    {
        return $this->hasOne(SystemConfigGroup::class, 'id', 'system_group_id');
    }
}
