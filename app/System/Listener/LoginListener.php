<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Listener;

use App\System\Event\UserLoginAfter;
use App\System\Model\SystemUser;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use HyperfAdminCore\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

#[Listener]
class LoginListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            UserLoginAfter::class,
        ];
    }

    /**
     * @param UserLoginAfter $event
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(object $event): void
    {
        $request = container()->get(Request::class);
        $ip = $request->ip();

        if ($event->loginStatus) {
            $event->userinfo['login_ip'] = $ip;
            $event->userinfo['login_time'] = date('Y-m-d H:i:s');

            SystemUser::query()->where('id', $event->userinfo['id'])->update([
                'login_ip' => $ip,
                'login_time' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
