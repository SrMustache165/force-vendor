<?php

declare(strict_types=1);

namespace ForceVendorCore;

use Fig\Http\Message\StatusCodeInterface as HttpCode;
use ForceVendorCore\Behavior\HttpResponseBehavior;
use ForceVendorCore\Exception\HttpBadRequestException;
use ForceVendorCore\Exception\HttpException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpSpecializedException;
use Slim\Interfaces\ErrorHandlerInterface;

class ErrorHandler implements ErrorHandlerInterface
{
    use HttpResponseBehavior;

    public function __invoke(
        ServerRequestInterface $request,
        \Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $payload = ['error' => $exception->getMessage()];

        $code = $exception instanceof HttpSpecializedException || $exception instanceof HttpException
            ? $exception->getCode()
            : HttpCode::STATUS_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpBadRequestException) {
            $payload = $exception->getErrors();
            $code = $exception->getCode();
        }

        return $this->respond($payload, $code);
    }
}
