<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Interfaces;

use App\System\Request\UploadFileRequest;

/**
 * 文件服务抽象
 */
interface FileServiceInterface
{
    public function upload(UploadFileRequest $request): string;
}
