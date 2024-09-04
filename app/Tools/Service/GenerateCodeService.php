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
            return Db::connection($params['pool'] ?? 'default')->select('SHOW TABLE STATUS');
        } catch (Throwable $e) {
            throw new AppException($e->getMessage(), 500);
        }
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
            'code' => (new RequestGenerator($params['module'], $params['name'], ['created_at', 'updated_at', 'deleted_at']))->preview(),
        ];

        return $result;
    }
}
