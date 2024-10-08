<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Mapper;

use App\System\Model\SystemMenu;
use App\System\Model\SystemUser;
use HyperfAdminCore\Abstracts\AbstractMapper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SystemMenuMapper extends AbstractMapper
{
    public $model;

    /**
     * 查询的菜单字段.
     */
    public array $menuField = [
        'id',
        'parent_id',
        'name',
        'code',
        'icon',
        'route',
        'component',
        'redirect',
        'hide_menu',
    ];

    public function assignModel(): void
    {
        $this->model = SystemMenu::class;
    }

    /**
     * 获取超级管理员的路由菜单.
     */
    public function getSuperAdminRouters(): array
    {
        return $this->model::query()
            ->select($this->menuField)
            ->where('status', $this->model::ENABLE)
            ->orderBy('sort', 'desc')
            ->get()
            ->sysMenuToRouterTree();
    }

    /**
     * 通过菜单ID列表获取菜单数据.
     */
    public function getRoutersByIds(array $ids): array
    {
        return $this->model::query()
            ->select($this->menuField)
            ->whereIn('id', $ids)
            ->where('status', $this->model::ENABLE)
            ->orderBy('sort', 'desc')
            ->get()
            ->sysMenuToRouterTree();
    }

    /**
     * 获取前端选择树.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSelectTree(): array
    {
        $query = $this->model::query()
            ->select(['id', 'parent_id', 'id AS key', 'name AS title'])
            ->where('status', $this->model::ENABLE)
            ->orderBy('sort', 'desc');

        if (! isSuperAdmin()) {
            $roleData = container()->get(SystemRoleMapper::class)->getMenuIdsByRoleIds(
                SystemUser::find(auth()->id(), ['id'])->roles()->pluck('id')->toArray()
            );

            $ids = [];
            foreach ($roleData as $val) {
                foreach ($val['menus'] as $menu) {
                    $ids[] = $menu['id'];
                }
            }
            unset($roleData);
            $query->whereIn('id', array_unique($ids));
        }

        return $query->get()->toTree();
    }
}
