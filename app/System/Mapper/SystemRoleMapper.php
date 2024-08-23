<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemRole;
use Hyperf\Database\Model\Builder;
use HyperfAdminCore\Abstracts\AbstractMapper;
use HyperfAdminCore\Annotation\Transaction;

class SystemRoleMapper extends AbstractMapper
{
    /**
     * @var SystemRole
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemRole::class;
    }

    public function getMenuIdsByRoleId($id): array
    {
        return $this->model::query()->where('id', $id)
            ->with(['menus' => function ($query) {
                $query->select('id')->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
            }])
            ->first(['id'])
            ->toArray();
    }

    /**
     * 通过角色ID列表获取菜单ID
     * @param array $ids
     * @return array
     */
    public function getMenuIdsByRoleIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return $this->model::query()
            ->whereIn('id', $ids)
            ->with(['menus' => function ($query) {
                $query->select('id')->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
            }])
            ->get(['id'])
            ->toArray();
    }

    /**
     * 检查角色code是否已存在
     * @param string $code
     * @return bool
     */
    public function checkRoleCode(string $code): bool
    {
        return $this->model::query()->where('code', $code)->exists();
    }

    public function handleSearch(Builder $query, ?array $params): Builder
    {
        if (!empty($params['name'])) {
            $query->whereRaw("name like '%" . $params['name'] . "%'");
        }
        if (isset($params['status']) && is_numeric($params['status'])) {
            $query->where(['status' => $params['status']]);
        }
        return $query;
    }

    /**
     * 更新角色
     * @param int $id
     * @param array $data
     * @return bool
     */
    #[Transaction]
    public function update(int $id, array $data): bool
    {
        $menuIds = $data['menu_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);
        $result = $this->model::query()->where('id', $id)->update($data);
        $role = $this->model::find($id);
        if ($role && !empty($menuIds)) {
            $role->menus()->sync(array_unique($menuIds));
            return true;
        }
        return boolval($result);
    }
}
