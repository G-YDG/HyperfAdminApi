<?php

declare(strict_types=1);

namespace App\Common\Exception\Handler;

use App\Common\Exception\UserException;
use Hyperf\Codec\Json;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class UserExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        $format = [
            'msg' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
        ];
        return $response->withHeader('Server', env('APP_NAME', 'Hyperf'))
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(200)
            ->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof UserException;
    }
}
