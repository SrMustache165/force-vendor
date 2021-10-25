<?php

declare(strict_types=1);

namespace ForceVendorCore\DTO;

use ForceVendorCore\Domain\Account\Account;
use ForceVendorCore\Interface\Arrayable;


class AccountConsultedDTO implements Arrayable
{
    private string $id;

    private string $name;

    private string $companyName;

    public function __construct(
        string $id,
        string $name,
        string $companyName
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->companyName = $companyName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'companyName' => $this->companyName
        ];
    }

    public static function buildFromAccount(Account $account): self
    {
        return new self(
            $account->getId(),
            $account->getName(),
            $account->getCompanyName()
        );
    }
}
