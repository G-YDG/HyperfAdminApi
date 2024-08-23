<?php

declare(strict_types=1);

namespace App\System\Controller;

use HyperfAdminCore\Abstracts\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use Psr\Http\Message\ResponseInterface;
use App\System\Service\SystemRoleService;
use App\System\Request\SystemRoleRequest;

#[Controller(prefix: 'system/role')]
class SystemRoleController extends AbstractController
{
    #[Inject]
    protected SystemRoleService $service;

    /**
     * 分页列表
     * @return ResponseInterface
     */
    #[GetMapping("index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 列表
     * @return ResponseInterface
     */
    #[GetMapping("list")]
    public function list(): ResponseInterface
    {
        return $this->success($this->service->getList($this->request->all()));
    }

    /**
     * 新增
     * @param SystemRoleRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("save"), Scene(scene: 'save')]
    public function save(SystemRoleRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 读取单个信息
     * @param int $id
     * @return ResponseInterface
     */
    #[GetMapping("read/{id}")]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新
     * @param int $id
     * @param SystemRoleRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("update/{id}"), Scene(scene: 'update')]
    public function update(int $id, SystemRoleRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除
     * @return ResponseInterface
     */
    #[PostMapping("delete")]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array)$this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 通过角色获取菜单IDS
     * @param int $id
     * @return ResponseInterface
     */
    #[GetMapping("getMenuIdsByRole/{id}")]
    public function getMenuIdsByRole(int $id): ResponseInterface
    {
        return $this->success($this->service->getMenuIdsByRole($id));
    }

    /**
     * 更新角色菜单权限
     * @param int $id
     * @return ResponseInterface
     */
    #[PostMapping("menuPermission/{id}")]
    public function menuPermission(int $id): ResponseInterface
    {
        return $this->service->update($id, $this->request->all()) ? $this->success() : $this->error();
    }
}
