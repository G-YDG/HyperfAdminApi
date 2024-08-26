<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

return [
    App\System\Interfaces\UserServiceInterface::class => App\System\Service\Dependencies\UserService::class,
    App\System\Interfaces\FileServiceInterface::class => App\System\Service\Dependencies\FileService::class,
];
