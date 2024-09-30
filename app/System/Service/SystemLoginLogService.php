<?php

declare(strict_types=1);

namespace App\System\Service;

use HyperfAdminCore\Abstracts\AbstractService;
use App\System\Mapper\SystemLoginLogMapper;

class SystemLoginLogService extends AbstractService
{
    public $mapper;

    public function __construct(SystemLoginLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
