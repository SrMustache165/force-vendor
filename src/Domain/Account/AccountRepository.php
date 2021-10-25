<?php

declare(strict_types=1);

namespace ForceVendorCore\Domain\Account;

interface AccountRepository
{
    public function save(Account $account): void;

    public function findById(string $id): ?Account;

    public function findByEmail(string $email): ?Account;

    public function update(Account $account): Account;
    
}
