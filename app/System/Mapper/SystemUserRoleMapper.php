<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Mapper;

use App\System\Model\SystemUserRole;
use HyperfAdminCore\Abstracts\AbstractMapper;

class SystemUserRoleMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemUserRole::class;
    }
}
