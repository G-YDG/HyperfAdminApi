<?php

declare(strict_types=1);

namespace App\System\Interfaces;

use App\System\Vo\UserServiceVo;

/**
 * 用户服务抽象
 */
interface UserServiceInterface
{
    public function login(UserServiceVo $userServiceVo);

    public function logout();
}