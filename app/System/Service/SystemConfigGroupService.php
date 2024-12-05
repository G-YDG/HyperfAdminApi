<?php

declare(strict_types=1);

namespace App\System\Service;

use App\Common\Exception\UserException;
use App\System\Mapper\SystemConfigGroupMapper;
use App\System\Model\SystemConfigGroup;
use HyperfAdminCore\Abstracts\AbstractService;

class SystemConfigGroupService extends AbstractService
{
    public $mapper;

    public function __construct(SystemConfigGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(array $data): int
    {
        if ($this->mapper->existsByKey($data['key'])) {
            throw new UserException('分组键值已存在');
        } else {
            return $this->mapper->save($data);
        }
    }

    public function delete(array $ids): bool
    {
        $groups = $this->mapper->getList(['id' => $ids]);
        foreach ($groups as $group) {
            if ($group['is_system'] == SystemConfigGroup::IS_SYSTEM) {
                throw new UserException("系统内置分组[{$group['key']}]不可进行删除");
            }
        }
        return parent::delete($ids);
    }

    public function getConfigsByGroupKey($key): array
    {
        return array_column($this->mapper->getConfigsByGroupKey($key), 'value', 'key');
    }
}
