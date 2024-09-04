<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
use App\Common\Exception\Handler\AppExceptionHandler;
use App\Common\Exception\Handler\AuthExceptionHandler;
use App\Common\Exception\Handler\HttpExceptionHandler;
use App\Common\Exception\Handler\UserExceptionHandler;
use App\Common\Exception\Handler\ValidationExceptionHandler;

/*
 * This file is part of HyperfAdmin.
 *
 *  * @see     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

return [
    'handler' => [
        'http' => [
            ValidationExceptionHandler::class,
            HttpExceptionHandler::class,
            AuthExceptionHandler::class,
            UserExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
