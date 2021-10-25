<?php

declare(strict_types=1);

namespace ForceVendorCore\Validator;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

abstract class Validator
{
    private ValidatorService $validator;

    public function __construct(ValidatorService $validator)
    {
        $this->validator = $validator;
    }

    public abstract function getRules(): array;

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody();
        $this->validator->validate($body, $this->getRules());
        $response = $handler->handle($request);
        return $response;
    }
}
