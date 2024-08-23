<?php

declare(strict_types=1);

namespace App\System\Mapper;

use HyperfAdminCore\Abstracts\AbstractMapper;
use App\System\Model\SystemUserRole;

class SystemUserRoleMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemUserRole::class;
    }
}
