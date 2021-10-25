<?php

declare(strict_types=1);

namespace ForceVendorCore\Application\Command\RegisterAccount;

use ForceVendorCore\Application\UuidGenerator;
use ForceVendorCore\Domain\Account\Exception\EmailAlreadyExistsException;
use ForceVendorCore\Domain\Account\Exception\LoginAlreadyExistsException;
use ForceVendorCore\Domain\Account\Account;
use ForceVendorCore\Domain\Account\AccountRepository;

final class RegisterAccountHandler
{
    public function __construct(private AccountRepository $repository, private UuidGenerator $uuid)
    {
        $this->repository = $repository;
        $this->uuid = $uuid;
    }

    public function handle(RegisterAccountCommand $command): string
    {
        if ($this->repository->findByEmail($command->getEmail())) {
            throw new EmailAlreadyExistsException($command->getEmail());
        }

        $account = new Account(
            $this->uuid->generate(),
            $command->getName(),
            $command->getEmail(),
            $command->getPassword(),
            $command->getCompanyName()
        );

        $this->repository->save($account);

        return $account->getId();
    }
}
