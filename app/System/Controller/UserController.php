<?php

declare(strict_types=1);

namespace App\System\Controller;

use App\Common\Helper\SpreadsheetExport;
use App\System\Request\SystemUserRequest;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/user'), Auth]
class UserController extends AbstractController
{
    #[Inject]
    protected SystemUserService $service;

    /**
     * 用户菜单
     * @return ResponseInterface
     */
    #[GetMapping("menu")]
    public function menu(): ResponseInterface
    {
        return $this->success($this->service->getMenus());
    }

    /**
     * 用户信息
     * @return ResponseInterface
     */
    #[GetMapping("getInfo")]
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->service->getInfo());
    }

    /**
     * 更改用户资料，含修改头像
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("updateInfo"), Scene(scene: 'modifyUserInfo')]
    public function updateInfo(SystemUserRequest $request): ResponseInterface
    {
        return $this->service->updateInfo(
            array_merge($this->request->all(), ['id' => auth()->id()])
        ) ? $this->success('保存成功') : $this->error();
    }


    /**
     * 修改密码
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("modifyPassword"), Scene(scene: 'modifyPassword')]
    public function modifyPassword(SystemUserRequest $request): ResponseInterface
    {
        return $this->service->modifyPassword($request->validated()) ? $this->success() : $this->error();
    }

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
     * 新增
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("save"), Scene(scene: 'save')]
    public function save(SystemUserRequest $request): ResponseInterface
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
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("update/{id}"), Scene(scene: 'update')]
    public function update(int $id, SystemUserRequest $request): ResponseInterface
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
     * @return ResponseInterface
     */
    #[GetMapping("export")]
    public function export(): ResponseInterface
    {
        $data = $this->service->getList(array_merge($this->request->all(), [
            'select' => 'id,username,created_at'
        ]));

        array_walk($data, function (&$datum) {
            $datum = [
                $datum['id'],
                $datum['username'],
                $datum['created_at'],
            ];
        });

        list($filepath, $filename) = make(SpreadsheetExport::class)
            ->fillWorksheet('用户信息', ['ID', '用户名', '创建时间'], $data)
            ->exportFile('用户信息');

        return $this->_download($filepath, $filename);
    }

}
