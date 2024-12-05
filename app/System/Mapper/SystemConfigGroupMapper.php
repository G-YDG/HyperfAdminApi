<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemConfigGroup;
use Hyperf\Database\Model\Builder;
use HyperfAdminCore\Abstracts\AbstractMapper;

class SystemConfigGroupMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemConfigGroup::class;
    }

    public function handleSearch(Builder $query, ?array $params): Builder
    {
        if (!empty($params['id'])) {
            $query->whereIn('id', is_array($params['id']) ? $params['id'] : [$params['id']]);
        }
        if (isset($params['key']) && filled($params['key'])) {
            $query->where('key', '=', $params['key']);
        }
        if (isset($params['name']) && filled($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        return $query;
    }

    public function existsByKey(string $key): bool
    {
        return $this->model::where('key', $key)->exists();
    }

    public function getConfigsByGroupKey($key): array
    {
        /**
         * @var SystemConfigGroup $group
         */
        $group = $this->model::query()->where('key', $key)->with(['configs:key,value,system_group_id'])->first();
        if (empty($group)) {
            return [];
        }
        return $group->configs->toArray();
    }
}
