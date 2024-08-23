<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

return [
    'handler' => [
        'http' => [
            App\Common\Exception\Handler\ValidationExceptionHandler::class,
            App\Common\Exception\Handler\HttpExceptionHandler::class,
            App\Common\Exception\Handler\AuthExceptionHandler::class,
            App\Common\Exception\Handler\UserExceptionHandler::class,
            App\Common\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
