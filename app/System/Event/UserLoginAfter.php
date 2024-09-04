<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Event;

class UserLoginAfter
{
    public bool $loginStatus = true;

    public array $userinfo;

    public string $message;

    public string $token;

    public function __construct(array $userinfo)
    {
        $this->userinfo = $userinfo;
    }
}
