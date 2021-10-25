<?php

declare(strict_types=1);

namespace ForceVendorCore\Behavior;

use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;

trait HttpResponseBehavior
{
    private function respond(array $serializable, int $code): Response
    {
        $json = json_encode($serializable, JSON_UNESCAPED_UNICODE);

        $response = (new ResponseFactory)->createResponse($code);

        $response->getBody()
            ->write($json);

        return $response->withHeader("Content-Type", 'application/json');
    }
}
