<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
use App\System\Interfaces\FileServiceInterface;
use App\System\Interfaces\UserServiceInterface;
use App\System\Service\Dependencies\FileService;
use App\System\Service\Dependencies\UserService;

/*
 * This file is part of HyperfAdmin.
 *
 *  * @see     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

return [
    UserServiceInterface::class => UserService::class,
    FileServiceInterface::class => FileService::class,
];
