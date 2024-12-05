<?php

declare(strict_types=1);

namespace App\System\Service;

use App\Common\Exception\UserException;
use App\System\Model\SystemConfig;
use HyperfAdminCore\Abstracts\AbstractService;
use App\System\Mapper\SystemConfigMapper;

class SystemConfigService extends AbstractService
{
    public $mapper;

    public function __construct(SystemConfigMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(array $data): int
    {
        if ($this->mapper->existsByKey($data['key'])) {
            throw new UserException('配置键值已存在');
        } else {
            return $this->mapper->save($data);
        }
    }

    public function delete(array $ids): bool
    {
        $configs = $this->mapper->getList(['id' => $ids]);
        foreach ($configs as $config) {
            if ($config['is_system'] == SystemConfig::IS_SYSTEM) {
                throw new UserException("系统内置配置[{$config['key']}]不可进行删除");
            }
        }
        return parent::delete($ids);
    }
}
