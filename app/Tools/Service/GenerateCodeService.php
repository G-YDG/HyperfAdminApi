<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\Tools\Service;

use App\Common\Exception\AppException;
use Hyperf\DbConnection\Db;
use HyperfAdminGenerator\ControllerGenerator;
use HyperfAdminGenerator\MapperGenerator;
use HyperfAdminGenerator\RequestGenerator;
use HyperfAdminGenerator\ServiceGenerator;
use Qbhy\HyperfAuth\Annotation\Auth;
use Throwable;

class GenerateCodeService
{
    public function getDataSourceTableList(array|object $params): array
    {
        try {
            $data = Db::connection(!empty($params['datasource']) ? $params['datasource'] : 'default')->select('SHOW TABLE STATUS');
            if (!empty($params['name'])) {
                $data = array_filter($data, function ($item) use ($params) {
                    return stripos($item->Name, $params['name']) !== false;
                });
                $data = array_values($data);
            }
        } catch (Throwable $e) {
            throw new AppException($e->getMessage(), 500);
        }
        return $data;
    }

    public function preview(array $params): array
    {
        $result[] = [
            'name' => 'controller',
            'label' => 'Controller.php',
            'lang' => 'php',
            'code' => (new ControllerGenerator($params['module'], $params['name'], Auth::class, true))->preview(),
        ];

        $result[] = [
            'name' => 'service',
            'label' => 'Service.php',
            'lang' => 'php',
            'code' => (new ServiceGenerator($params['module'], $params['name']))->preview(),
        ];

        $result[] = [
            'name' => 'mapper',
            'label' => 'Mapper.php',
            'lang' => 'php',
            'code' => (new MapperGenerator($params['module'], $params['name']))->preview(),
        ];

        $result[] = [
            'name' => 'request',
            'label' => 'Request.php',
            'lang' => 'php',
            'code' => (new RequestGenerator(
                $params['module'],
                $params['name'],
                ['created_at', 'updated_at', 'deleted_at'],
                null,
                !empty($params['datasource']) ? $params['datasource'] : 'default',
            ))->preview(),
        ];

        return $result;
    }

    public function datasource(): array
    {
        $datasource = [];
        foreach (config('databases') as $key => $item) {
            $datasource[] = [
                'label' => $item['database'],
                'value' => $key,
            ];
        }
        return $datasource;
    }
}
