<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemConfig;
use Hyperf\Database\Model\Builder;
use HyperfAdminCore\Abstracts\AbstractMapper;

class SystemConfigMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemConfig::class;
    }

    public function handleSearch(Builder $query, ?array $params): Builder
    {
        if (!empty($params['id'])) {
            $query->whereIn('id', is_array($params['id']) ? $params['id'] : [$params['id']]);
        }
        if (isset($params['system_group_id']) && filled($params['system_group_id'])) {
            $query->where('system_group_id', '=', $params['system_group_id']);
        }
        if (isset($params['remark']) && filled($params['remark'])) {
            $query->where('remark', 'like', '%' . $params['remark'] . '%');
        }
        return $query;
    }

    public function existsByKey(string $key): bool
    {
        return $this->model::where('key', $key)->exists();
    }
}
