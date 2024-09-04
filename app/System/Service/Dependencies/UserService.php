<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Service\Dependencies;

use App\Common\Constants\ErrorCode;
use App\System\Event\UserLoginAfter;
use App\System\Exception\NormalStatusException;
use App\System\Exception\UserBanException;
use App\System\Interfaces\UserServiceInterface;
use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemUser;
use App\System\Vo\UserServiceVo;
use Exception;
use Hyperf\Database\Model\ModelNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserService implements UserServiceInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function login(UserServiceVo $userServiceVo): string
    {
        $mapper = container()->get(SystemUserMapper::class);

        try {
            $user = $mapper->checkUserByUsername($userServiceVo->getUsername());
            $userLoginAfter = new UserLoginAfter($user->toArray());
            if ($mapper->checkPass($userServiceVo->getPassword(), $user->password)) {
                if (($user->status == SystemUser::USER_NORMAL) || ($user->status == SystemUser::USER_BAN && $user->id == superAdminUserId())) {
                    $token = auth()->login($user);
                    $userLoginAfter->message = '登录成功';
                    $userLoginAfter->token = $token;
                    event($userLoginAfter);
                    return $token;
                }
                $userLoginAfter->loginStatus = false;
                $userLoginAfter->message = '用户被禁用';
                event($userLoginAfter);
                throw new UserBanException();
            }
            $userLoginAfter->loginStatus = false;
            $userLoginAfter->message = '用户不存在或密码不正确';
            event($userLoginAfter);
            throw new NormalStatusException();
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                throw new NormalStatusException('用户不存在或密码不正确', ErrorCode::NO_USER);
            }
            if ($e instanceof NormalStatusException) {
                throw new NormalStatusException('用户不存在或密码不正确', ErrorCode::NO_USER);
            }
            if ($e instanceof UserBanException) {
                throw new NormalStatusException('用户被禁用', ErrorCode::USER_BAN);
            }
            console()->error($e->getMessage());
            throw new NormalStatusException('未知错误');
        }
    }

    public function logout()
    {
        auth()->logout();
    }
}
