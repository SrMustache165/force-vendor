<?php

declare(strict_types=1);

namespace ForceVendorCore\Exception;

final class HttpException extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
