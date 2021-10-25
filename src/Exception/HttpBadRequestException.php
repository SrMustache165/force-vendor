<?php

declare(strict_types=1);

namespace ForceVendorCore\Exception;

use Fig\Http\Message\StatusCodeInterface as HttpCode;

final class HttpBadRequestException extends \Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        parent::__construct(self::class, HttpCode::STATUS_BAD_REQUEST);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
