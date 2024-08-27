<?php

declare(strict_types=1);

namespace App\Tools\Controller;

use App\Tools\Request\GenerateCodeRequest;
use App\Tools\Service\GenerateCodeService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'tools/generateCode'), Auth]
class GenerateCodeController extends AbstractController
{
    #[Inject]
    protected GenerateCodeService $service;

    /**
     * @return ResponseInterface
     */
    #[GetMapping("index")]
    public function index(): ResponseInterface
    {
        return $this->success([
            'items' => $this->service->getDataSourceTableList($this->request->all())
        ]);
    }

    #[GetMapping("preview")]
    public function preview(GenerateCodeRequest $request): ResponseInterface
    {
        return $this->success($this->service->preview($request->all()));
    }
}
