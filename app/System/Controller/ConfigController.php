<?php

declare(strict_types=1);

namespace App\System\Controller;

use App\System\Request\SystemConfigRequest;
use App\System\Service\SystemConfigService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/config'), Auth]
class ConfigController extends AbstractController
{
    #[Inject]
    protected SystemConfigService $service;

    /**
     * 分页列表
     * @return ResponseInterface
     */
    #[GetMapping("index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList(array_merge($this->request->all(), ['with' => ['group']])));
    }

    /**
     * 新增
     * @param SystemConfigRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("save"), Scene(scene: 'save')]
    public function save(SystemConfigRequest $request): ResponseInterface
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
     * @param SystemConfigRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("update/{id}"), Scene(scene: 'update')]
    public function update(int $id, SystemConfigRequest $request): ResponseInterface
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
}
