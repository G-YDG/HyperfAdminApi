<?php

namespace App\System\Service\Dependencies;

use App\Common\Constants\ErrorCode;
use App\System\Exception\NormalStatusException;
use App\System\Exception\UserBanException;
use App\System\Interfaces\UserServiceInterface;
use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemUser;
use App\System\Vo\UserServiceVo;
use Hyperf\Database\Model\ModelNotFoundException;

class UserService implements UserServiceInterface
{
    public function login(UserServiceVo $userServiceVo)
    {
        $mapper = container()->get(SystemUserMapper::class);

        try {
            $user = $mapper->checkUserByUsername($userServiceVo->getUsername());
            if ($mapper->checkPass($userServiceVo->getPassword(), $user->password)) {
                if (($user->status == SystemUser::USER_NORMAL) || ($user->status == SystemUser::USER_BAN && $user->id == superAdminUserId())) {
                    return auth()->login($user);
                } else {
                    throw new UserBanException;
                }
            } else {
                throw new NormalStatusException;
            }
        } catch (\Exception $e) {
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