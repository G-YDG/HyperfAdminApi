<?php

declare(strict_types=1);

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