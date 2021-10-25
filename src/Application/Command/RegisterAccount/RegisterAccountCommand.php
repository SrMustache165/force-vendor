<?php

declare(strict_types=1);

namespace ForceVendorCore\Application\Command\RegisterAccount;

final class RegisterAccountCommand
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private string $passwordConfirmation,
        private string $companyName
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->companyName = $companyName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
