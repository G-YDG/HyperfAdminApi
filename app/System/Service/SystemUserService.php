<?php

declare(strict_types=1);

namespace App\System\Service;

use App\Common\Exception\AppException;
use App\Common\Exception\UserException;
use App\Common\Helper\SpreadsheetExport;
use App\System\Mapper\SystemUserMapper;
use HyperfAdminCore\Abstracts\AbstractService;

class SystemUserService extends AbstractService
{
    public $mapper;

    /**
     * @var SystemMenuService
     */
    protected SystemMenuService $systemMenuService;

    /**
     * @var SystemRoleService
     */
    protected SystemRoleService $systemRoleService;

    public function __construct(SystemUserMapper $mapper, SystemMenuService $systemMenuService, SystemRoleService $systemRoleService)
    {
        $this->mapper = $mapper;
        $this->systemMenuService = $systemMenuService;
        $this->systemRoleService = $systemRoleService;
    }

    /**
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        if ($this->mapper->existsByUsername($data['username'])) {
            throw new UserException('管理员用户名已存在');
        } else {
            return $this->mapper->save($this->handleData($data));
        }
    }

    /**
     * 处理提交数据
     * @param $data
     * @return array
     */
    protected function handleData($data): array
    {
        if (isset($data['id']) && $data['id'] == superAdminUserId()) {
            throw new UserException('超级管理员用户不可进行操作');
        }
        if (isset($data['role_id'])) {
            $data['role_ids'] = [$data['role_id']];
        }
        if (isset($data['role_ids']) && !is_array($data['role_ids'])) {
            $data['role_ids'] = explode(',', (string)$data['role_ids']);
        }
        return $data;
    }

    /**
     * 更新用户信息
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        if (isset($data['username'])) unset($data['username']);
        if (isset($data['password'])) unset($data['password']);
        return $this->mapper->update($id, $this->handleData($data));
    }

    /**
     * 删除用户
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids): bool
    {
        if (!empty($ids)) {
            if (in_array(superAdminUserId(), $ids)) {
                throw new UserException('不可删除超级管理员用户');
            }
            return $this->mapper->delete($ids);
        }
        return false;
    }

    /**
     * 获取用户信息
     * @return array
     */
    public function getInfo(): array
    {
        if (($uid = auth()->id())) {
            $user = $this->mapper->getModel()->with(['roles:id,name,code,status'])->find($uid);
            $user->addHidden('deleted_at', 'password');
            $user = $user->toArray();
            $user['roles'] = array_column($user['roles'], 'code');
            return $user;
        }
        throw new AppException('用户信息无法获取', 500);
    }

    public function getMenus(): array
    {
        if (($uid = auth()->id())) {
            if (isSuperAdmin()) {
                return $this->systemMenuService->mapper->getSuperAdminRouters();
            } else {
                $user = $this->mapper->getModel()->find($uid);
                $roles = $this->systemRoleService->mapper->getMenuIdsByRoleIds($user->roles()->pluck('id')->toArray());
                $ids = $this->filterMenuIds($roles);
                return $this->systemMenuService->mapper->getRoutersByIds($ids);
            }
        }
        throw new AppException('用户信息无法获取', 500);
    }

    /**
     * 过滤通过角色查询出来的菜单id列表，并去重
     * @param array $roleData
     * @return array
     */
    protected function filterMenuIds(array &$roleData): array
    {
        $ids = [];
        foreach ($roleData as $val) {
            foreach ($val['menus'] as $menu) {
                $ids[] = $menu['id'];
            }
        }
        unset($roleData);
        return array_unique($ids);
    }

    /**
     * 用户更新个人资料
     * @param array $params
     * @return bool
     */
    public function updateInfo(array $params): bool
    {
        if (!isset($params['id'])) {
            return false;
        }

        $model = $this->mapper->getModel()::find($params['id']);
        unset($params['id'], $params['password']);
        foreach ($params as $key => $param) {
            $model[$key] = $param;
        }

        return $model->save();
    }

    /**
     * 用户修改密码
     * @param array $params
     * @return bool
     */
    public function modifyPassword(array $params): bool
    {
        return $this->mapper->initUserPassword((int)auth()->id(), $params['newPassword']);
    }

    public function export(): array
    {
        $data = $this->getList([
            'select' => 'id,username,created_at'
        ]);

        array_walk($data, function (&$datum) {
            $datum = [
                $datum['id'],
                $datum['username'],
                $datum['created_at'],
            ];
        });

        return make(SpreadsheetExport::class)
            ->fillWorksheet('用户信息', ['ID', '用户名', '创建时间'], $data)
            ->writeToLocal('用户信息表格');
    }
}
