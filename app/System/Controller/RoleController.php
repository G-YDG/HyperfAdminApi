<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Controller;

use App\System\Request\SystemRoleRequest;
use App\System\Service\SystemRoleService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/role'), Auth]
class RoleController extends AbstractController
{
    #[Inject]
    protected SystemRoleService $service;

    /**
     * 分页列表.
     */
    #[GetMapping('index')]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 列表.
     */
    #[GetMapping('list')]
    public function list(): ResponseInterface
    {
        return $this->success($this->service->getList($this->request->all()));
    }

    /**
     * 新增.
     */
    #[PostMapping('save'), Scene(scene: 'save')]
    public function save(SystemRoleRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 读取单个信息.
     */
    #[GetMapping('read/{id}')]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新.
     */
    #[PostMapping('update/{id}'), Scene(scene: 'update')]
    public function update(int $id, SystemRoleRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除.
     */
    #[PostMapping('delete')]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 通过角色获取菜单IDS.
     */
    #[GetMapping('getMenuIdsByRole/{id}')]
    public function getMenuIdsByRole(int $id): ResponseInterface
    {
        return $this->success($this->service->getMenuIdsByRole($id));
    }

    /**
     * 更新角色菜单权限.
     */
    #[PostMapping('menuPermission/{id}')]
    public function menuPermission(int $id): ResponseInterface
    {
        return $this->service->update($id, $this->request->all()) ? $this->success() : $this->error();
    }
}
