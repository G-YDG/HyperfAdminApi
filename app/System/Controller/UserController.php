<?php

declare(strict_types=1);

namespace App\System\Controller;

use App\System\Interfaces\UserServiceInterface;
use App\System\Request\SystemUserRequest;
use App\System\Service\SystemUserService;
use App\System\Vo\UserServiceVo;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/user')]
class UserController extends AbstractController
{
    #[Inject]
    protected SystemUserService $service;

    #[Inject]
    protected UserServiceInterface $userService;

    /**
     * 用户登录
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("login"), Scene(scene: 'login')]
    public function login(SystemUserRequest $request): ResponseInterface
    {
        $requestData = $request->validated();

        $vo = new UserServiceVo();
        $vo->setUsername($requestData['username']);
        $vo->setPassword($requestData['password']);

        return $this->success(['token' => $this->userService->login($vo)]);
    }

    /**
     * 用户登出
     * @return ResponseInterface
     */
    #[PostMapping("logout"), Auth]
    public function logout(): ResponseInterface
    {
        $this->userService->logout();
        return $this->success();
    }

    /**
     * 用户信息
     * @return ResponseInterface
     */
    #[GetMapping("getInfo"), Auth]
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->service->getInfo());
    }

    /**
     * 更改用户资料，含修改头像
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("updateInfo"), Scene(scene: 'modifyUserInfo'), Auth]
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
     * 用户菜单
     * @return ResponseInterface
     */
    #[GetMapping("menu"), Auth]
    public function menu(): ResponseInterface
    {
        return $this->success($this->service->getMenus());
    }

    /**
     * 分页列表
     * @return ResponseInterface
     */
    #[GetMapping("index"), Auth]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 新增
     * @param SystemUserRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("save"), Scene(scene: 'save'), Auth]
    public function save(SystemUserRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 读取单个信息
     * @param int $id
     * @return ResponseInterface
     */
    #[GetMapping("read/{id}"), Auth]
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
    #[PostMapping("update/{id}"), Scene(scene: 'update'), Auth]
    public function update(int $id, SystemUserRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除
     * @return ResponseInterface
     */
    #[PostMapping("delete"), Auth]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array)$this->request->input('ids', [])) ? $this->success() : $this->error();
    }
}
