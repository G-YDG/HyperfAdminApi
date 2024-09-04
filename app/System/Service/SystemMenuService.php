<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Service;

use App\System\Mapper\SystemMenuMapper;
use HyperfAdminCore\Abstracts\AbstractService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SystemMenuService extends AbstractService
{
    public $mapper;

    public function __construct(SystemMenuMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getTreeList(?array $params = null): array
    {
        $params = array_merge(['orderBy' => 'sort', 'orderType' => 'desc'], $params);
        return parent::getTreeList($params);
    }

    /**
     * 获取前端选择树.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSelectTree(): array
    {
        return $this->mapper->getSelectTree();
    }
}
