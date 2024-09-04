<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
use App\Common\Middleware\CorsMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;

/*
 * This file is part of HyperfAdmin.
 *
 *  * @see     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
return [
    'http' => [
        ValidationMiddleware::class,
        CorsMiddleware::class,
    ],
];
