<?php

declare(strict_types=1);

if (!function_exists('isSuperAdmin')) {
    /**
     * 是否为超级管理员
     * @return bool
     */
    function isSuperAdmin(): bool
    {
        return auth()->id() == superAdminUserId();
    }

}

if (!function_exists('superAdminUserId')) {
    /**
     * 超级管理员用户ID
     * @return string|int|null
     */
    function superAdminUserId(): int|string|null
    {
        return env('SUPER_ADMIN_USER_ID', 1);
    }

}

if (!function_exists('superAdminRoleId')) {
    /**
     * 超级管理员角色ID
     * @return string|int|null
     */
    function superAdminRoleId(): int|string|null
    {
        return env('SUPER_ADMIN_ROLE_ID', 1);
    }

}