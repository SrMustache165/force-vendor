<?php

declare(strict_types=1);

namespace ForceVendorCore\Domain\Account;

use ForceVendorCore\Domain\Account\Exception\InsufficientFundsException;
use Ramsey\Uuid\Uuid;

final class Account
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $password,
        private string $companyName
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->companyName = $companyName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
