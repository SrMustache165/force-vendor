<?php

declare(strict_types=1);

namespace ForceVendorCore\Domain\Account\Exception;

final class LoginAlreadyExistsException extends \Exception
{
    public function __construct(string $login)
    {
        parent::__construct("Already exists login: '{$login}'");
    }
}
