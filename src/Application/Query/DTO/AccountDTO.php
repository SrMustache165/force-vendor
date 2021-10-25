<?php

declare(strict_types=1);

namespace ForceVendorCore\Application\Query\DTO;

use ForceVendorCore\Domain\Account\Account;
use ForceVendorCore\Interface\Arrayable;

class AccountDTO implements Arrayable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $companyName
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->companyName = $companyName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'companyName' => $this->companyName,
        ];
    }

    public static function buildFromAccount(Account $account): self
    {
        return new self(
            $account->getId(),
            $account->getName(),
            $account->getEmail(),
            $account->getCompanyName()
        );
    }
}
