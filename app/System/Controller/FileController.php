<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Controller;

use App\System\Interfaces\FileServiceInterface;
use App\System\Request\UploadFileRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;

#[Controller(prefix: 'system/file'), Auth]
class FileController extends AbstractController
{
    #[Inject]
    protected FileServiceInterface $service;

    /**
     * 文件上传.
     */
    #[PostMapping('upload')]
    public function upload(UploadFileRequest $request): ResponseInterface
    {
        return $this->success(['url' => $this->service->upload($request)]);
    }
}
