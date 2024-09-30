<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Controller;

use App\System\Service\SystemLoginLogService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/logs'), Auth]
class LogsController extends AbstractController
{
    #[Inject]
    protected SystemLoginLogService $loginLogService;

    /**
     * 获取登录日志分页列表.
     */
    #[GetMapping('getLoginLogPageList')]
    public function getLoginLogPageList(): ResponseInterface
    {
        return $this->success($this->loginLogService->getPageList($this->request->all()));
    }

    /**
     * 删除登录日志.
     */
    #[PostMapping('deleteLoginLog')]
    public function deleteLoginLog(): ResponseInterface
    {
        return $this->loginLogService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }
}
