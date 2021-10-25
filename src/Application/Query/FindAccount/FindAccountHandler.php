<?php

declare(strict_types=1);

namespace ForceVendorCore\Application\Query\FindAccount;

use ForceVendorCore\Application\Query\DTO\AccountDTO;
use ForceVendorCore\Domain\Account\AccountRepository;
use ForceVendorCore\Domain\Account\Exception\AccountNotFoundException;

final class FindAccountHandler
{

    public function __construct(private AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(FindAccountQuery $query): AccountDTO
    {
        $account = $this->repository->findById($query->getId());

        if (!$account) {
            throw new AccountNotFoundException($query->getId());
        }

        return AccountDTO::buildFromAccount($account);
    }
}
