<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Controller;

use App\System\Interfaces\UserServiceInterface;
use App\System\Request\SystemUserRequest;
use App\System\Vo\UserServiceVo;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Annotation\Scene;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system')]
class HomeController extends AbstractController
{
    #[Inject]
    protected UserServiceInterface $userService;

    /**
     * 用户登录.
     */
    #[PostMapping('login'), Scene(scene: 'login')]
    public function login(SystemUserRequest $request): ResponseInterface
    {
        $requestData = $request->validated();

        $vo = new UserServiceVo();
        $vo->setUsername($requestData['username']);
        $vo->setPassword($requestData['password']);

        return $this->success(['token' => $this->userService->login($vo)]);
    }

    /**
     * 用户登出.
     */
    #[PostMapping('logout'), Auth]
    public function logout(): ResponseInterface
    {
        $this->userService->logout();
        return $this->success();
    }
}
