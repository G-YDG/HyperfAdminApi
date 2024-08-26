<?php

declare(strict_types=1);

namespace App\System\Controller;

use App\System\Interfaces\FileServiceInterface;
use App\System\Request\UploadFileRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: 'system/file')]
class FileController extends AbstractController
{
    #[Inject]
    protected FileServiceInterface $service;

    /**
     * 文件上传
     * @param UploadFileRequest $request
     * @return ResponseInterface
     */
    #[PostMapping("upload")]
    public function upload(UploadFileRequest $request): ResponseInterface
    {
        return $this->success(['url' => $this->service->upload($request)]);
    }
}
