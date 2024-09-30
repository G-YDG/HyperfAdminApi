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

    public function save(array $data): int
    {
        return $this->mapper->save($this->handleData($data));
    }

    protected function handleData(array $data): array
    {
        if (empty($data['parent_id']) || $data['parent_id'] == 0) {
            $data['level'] = '0';
            $data['parent_id'] = 0;
        } else {
            $parentMenu = $this->mapper->read((int)$data['parent_id']);
            $data['level'] = $parentMenu['level'] . ',' . $parentMenu['id'];
        }
        return $data;
    }

    public function update(int $id, array $data): bool
    {
        return $this->mapper->update($id, $this->handleData($data));
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
