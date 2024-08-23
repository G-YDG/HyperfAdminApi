<?php

namespace App\Common\Exception\Handler;

use Hyperf\Codec\Json;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;

class HttpExceptionHandler extends \Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler
{
    /**
     * Handle the exception, and return the specified result.
     * @param HttpException $throwable
     */
    public function handle(\Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->debug($this->formatter->format($throwable));

        $this->stopPropagation();

        $format = [
            'msg' => $throwable->getMessage() ?: 'ERROR',
            'code' => (int)$throwable->getStatusCode(),
        ];

        return $response->withHeader('Server', env('APP_NAME', 'Hyperf'))
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus($throwable->getStatusCode())
            ->withBody(new SwooleStream(Json::encode($format)));
    }
}