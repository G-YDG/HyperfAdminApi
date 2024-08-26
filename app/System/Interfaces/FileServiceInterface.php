<?php

declare(strict_types=1);

namespace App\System\Interfaces;

use App\System\Request\UploadFileRequest;

/**
 * 文件服务抽象
 */
interface FileServiceInterface
{
    public function upload(UploadFileRequest $request): string;
}