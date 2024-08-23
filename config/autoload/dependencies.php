<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

use App\System\Interfaces\UserServiceInterface;
use App\System\Service\Dependencies\UserService;

return [
    UserServiceInterface::class => UserService::class,
];
