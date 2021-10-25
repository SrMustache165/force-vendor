<?php

declare(strict_types=1);

namespace ForceVendorCore\Domain\Account\Exception;

final class EmailAlreadyExistsException extends \Exception
{
    public function __construct(string $email)
    {
        parent::__construct("Already exists email: '{$email}'");
    }
}
