<?php

namespace App\System\Service\Dependencies;

use App\Common\Constants\ErrorCode;
use App\Common\Exception\UserException;
use App\System\Interfaces\FileServiceInterface;
use App\System\Request\UploadFileRequest;
use Hyperf\Di\Annotation\Inject;
use League\Flysystem\Filesystem;

class FileService implements FileServiceInterface
{
    #[Inject]
    protected Filesystem $filesystem;

    public function upload(UploadFileRequest $request): string
    {
        $file = $request->file('file');

        try {
            $stream = fopen($file->getRealPath(), 'r+');
            $fileName = $this->generateFileName($file);
            $this->filesystem->writeStream($fileName, $stream);
        } catch (\Throwable $e) {
            throw new UserException($e->getMessage(), ErrorCode::SERVER_ERROR);
        } finally {
            if (isset($stream) && is_resource($stream)) {
                fclose($stream);
            }
        }

        return config('base_url') . '/' . $fileName;
    }

    protected function generateFileName($file): string
    {
        return md5( $file->getClientFilename()) . '.' . $file->getExtension();
    }
}