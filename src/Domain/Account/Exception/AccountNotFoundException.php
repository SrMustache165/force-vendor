<?php

declare(strict_types=1);

namespace ForceVendorCore\Domain\Account\Exception;

final class AccountNotFoundException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct("The account id: '{$id}' was not found");
    }
}
