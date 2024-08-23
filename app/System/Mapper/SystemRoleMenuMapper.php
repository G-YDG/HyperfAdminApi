<?php

declare(strict_types=1);

namespace App\System\Mapper;

use HyperfAdminCore\Abstracts\AbstractMapper;
use App\System\Model\SystemRoleMenu;

class SystemRoleMenuMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemRoleMenu::class;
    }
}
