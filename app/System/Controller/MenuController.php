<?php

declare(strict_types=1);

namespace App\System\Controller;

use HyperfAdminCore\Abstracts\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use App\System\Service\SystemMenuService;
use App\System\Request\SystemMenuRequest;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/menu'), Auth]
class MenuController extends AbstractController
{
    #[Inject]
    protected SystemMenuService $service;

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
        return $this->success([
            'items' => $this->service->getTreeList($this->request->all())
        ]);
    }

    /**
     * 新增
     * @param SystemMenuRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("save"), Scene(scene: 'save')]
    public function save(SystemMenuRequest $request): ResponseInterface
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
     * @param SystemMenuRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("update/{id}"), Scene(scene: 'update')]
    public function update(int $id, SystemMenuRequest $request): ResponseInterface
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
     * 前端选择树
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("tree")]
    public function tree(): ResponseInterface
    {
        return $this->success($this->service->getSelectTree());
    }

}
