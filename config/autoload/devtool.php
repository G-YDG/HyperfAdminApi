<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
return [
    'generator' => [
        'amqp' => [
            'consumer' => [
                'namespace' => 'App\Common\Amqp\Consumer',
            ],
            'producer' => [
                'namespace' => 'App\Common\Amqp\Producer',
            ],
        ],
        'aspect' => [
            'namespace' => 'App\Common\Aspect',
        ],
        'command' => [
            'namespace' => 'App\Common\Command',
        ],
        'controller' => [
            'namespace' => 'App\Common\Controller',
        ],
        'job' => [
            'namespace' => 'App\Common\Job',
        ],
        'listener' => [
            'namespace' => 'App\Common\Listener',
        ],
        'middleware' => [
            'namespace' => 'App\Common\Middleware',
        ],
        'Process' => [
            'namespace' => 'App\Common\Processes',
        ],
    ],
];
