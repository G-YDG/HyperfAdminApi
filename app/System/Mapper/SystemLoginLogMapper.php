<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Mapper;

use App\System\Model\SystemLoginLog;
use Hyperf\Database\Model\Builder;
use HyperfAdminCore\Abstracts\AbstractMapper;

class SystemLoginLogMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemLoginLog::class;
    }

    public function handleSearch(Builder $query, ?array $params): Builder
    {
        if (isset($params['ip']) && filled($params['ip'])) {
            $query->where('ip', $params['ip']);
        }

        if (isset($params['username']) && filled($params['username'])) {
            $query->where('username', 'like', '%' . $params['username'] . '%');
        }

        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['login_time']) && filled($params['login_time']) && is_array($params['login_time']) && count($params['login_time']) == 2) {
            $query->whereBetween('login_time', [$params['login_time'][0] . ' 00:00:00', $params['login_time'][1] . ' 23:59:59']);
        }

        return $query;
    }

    public function handleOrder(Builder $query, ?array &$params = null): Builder
    {
        $params['orderBy'] = 'login_time';
        $params['orderType'] = 'desc';
        return parent::handleOrder($query, $params);
    }
}
