<?php

namespace App\Middleware;

use App\Renderer\JsonRenderer;
use DomainException;
use InvalidArgumentException;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Throwable;

class ExceptionMiddleware implements MiddlewareInterface
{
    private ResponseFactory $responseFactory;
    private JsonRenderer $renderer;

    public function __construct(ResponseFactory $responseFactory, JsonRenderer $jsonRenderer)
    {
        $this->responseFactory = $responseFactory;
        $this->renderer = $jsonRenderer;
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            return $this->render($exception, $request);
        }
    }

    private function render(Throwable $exception, Request $request): Response
    {
        $httpStatusCode = $this->getHttpStatusCode($exception);
        $response = $this->responseFactory->createResponse($httpStatusCode);

        $response = $response->withAddedHeader('Content-Type', 'application/json');

        $data = [
            'error' => [
                'message' => $exception->getMessage(),
            ],
        ];

        return $this->renderer->json($response, $data);
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        $statusCode = Status::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
        }

        if ($exception instanceof DomainException || $exception instanceof InvalidArgumentException) {
            $statusCode = Status::HTTP_BAD_REQUEST;
        }

        return $statusCode;
    }
}
