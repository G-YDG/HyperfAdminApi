<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Service;

use App\Common\Exception\UserException;
use App\System\Exception\NormalStatusException;
use App\System\Mapper\SystemRoleMapper;
use HyperfAdminCore\Abstracts\AbstractService;

class SystemRoleService extends AbstractService
{
    public $mapper;

    public function __construct(SystemRoleMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 通过角色获取菜单.
     */
    public function getMenuIdsByRole(int $id): array
    {
        $data = $this->mapper->getMenuIdsByRoleId($id);
        if (empty($data['menus'])) {
            return [];
        }
        return array_column($data['menus'], 'id');
    }

    /**
     * 新增角色.
     */
    public function save(array $data): int
    {
        if ($this->mapper->checkRoleCode($data['code'])) {
            throw new NormalStatusException('角色代码已存在');
        }
        return $this->mapper->save($this->handleData($data));
    }

    /**
     * 更新角色信息.
     */
    public function update(int $id, array $data): bool
    {
        if ($id == superAdminRoleId()) {
            throw new UserException('不可进行操作超级管理员角色');
        }
        return $this->mapper->update($id, $this->handleData($data));
    }

    public function delete(array $ids): bool
    {
        if (in_array(superAdminRoleId(), $ids)) {
            throw new UserException('不可删除超级管理员角色');
        }
        return ! empty($ids) && $this->mapper->delete($ids);
    }

    /**
     * 处理提交数据.
     * @param mixed $data
     */
    protected function handleData($data): array
    {
        if (isset($data['menu_ids']) && ! is_array($data['menu_ids'])) {
            $data['menu_ids'] = explode(',', $data['menu_ids']);
        }
        return $data;
    }
}
