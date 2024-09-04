<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
if (! function_exists('isSuperAdmin')) {
    /**
     * 是否为超级管理员.
     */
    function isSuperAdmin(): bool
    {
        return auth()->id() == superAdminUserId();
    }
}

if (! function_exists('superAdminUserId')) {
    /**
     * 超级管理员用户ID.
     */
    function superAdminUserId(): null|int|string
    {
        return env('SUPER_ADMIN_USER_ID', 1);
    }
}

if (! function_exists('superAdminRoleId')) {
    /**
     * 超级管理员角色ID.
     */
    function superAdminRoleId(): null|int|string
    {
        return env('SUPER_ADMIN_ROLE_ID', 1);
    }
}
