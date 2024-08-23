<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
return [
    'http' => [
        Hyperf\Validation\Middleware\ValidationMiddleware::class,
        App\Common\Middleware\CorsMiddleware::class,
    ],
];
