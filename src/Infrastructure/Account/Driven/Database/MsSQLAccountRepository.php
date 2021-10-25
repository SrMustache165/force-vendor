<?php

declare(strict_types=1);

namespace ForceVendorCore\Infrastructure\Account\Driven\Database;

use Doctrine\DBAL\Connection;
use ForceVendorCore\Domain\Account\Account;
use ForceVendorCore\Domain\Account\AccountRepository;

class MsSQLAccountRepository implements AccountRepository
{
    private Connection $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function save(Account $account): void
    {
        $usersQueryBuilder = $this->conn->createQueryBuilder();
        $cashShopDataQueryBuilder = $this->conn->createQueryBuilder();

        $usersQueryBuilder
            ->insert('force.dbo.Users')
            ->setValue('Id', ':id')
            ->setValue('Email', ':email')
            ->setValue('Password', ':password')
            ->setValue('Name', ':name')
            ->setValue('CompanyName', ':CompanyName')
            ->setParameter('id', $account->getId())
            ->setParameter('email', $account->getEmail())
            ->setParameter('password', $account->getPassword())
            ->setParameter('name', $account->getName())
            ->setParameter('CompanyName', $account->getCompanyName())
            ->executeQuery();
    }

    public function findById(string $account_id): ?Account
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        $account = $queryBuilder
            ->select(
                'Id',
                'Name',
                'Email',
                'Password',
                'CompanyName'
            )
            ->from('force.dbo.Users')
            ->where('Users.Id = :id')
            ->setParameter('id', $account_id)
            ->fetchAssociative();

        if (!$account) {
            return null;
        }

        return new Account(
            $account['Id'],
            $account['Name'],
            $account['Email'],
            $account['Password'],
            $account['CompanyName']
        );
    }

    public function findByEmail(string $email): ?Account
    {
        $queryBuilder = $this->conn->createQueryBuilder();

        $account = $queryBuilder
            ->select(
                'Id',
                'Email',
                'Name',
                'Password',
                'CompanyName'
            )
            ->from('force.dbo.Users')
            ->where('Users.Email = :email')
            ->setParameter('email', $email)
            ->fetchAssociative();

        if (!$account) {
            return null;
        }

        return new Account(
            $account['Id'],
            $account['Name'],
            $account['Email'],
            $account['Password'],
            $account['CompanyName']
        );
    }

    public function update(Account $account): Account
    {
        $QueryBuilder = $this->conn->createQueryBuilder();
        $csdQueryBuilder = $this->conn->createQueryBuilder();

        $QueryBuilder
            ->update('force.dbo.Users')
            ->set('Email', ':email')
            ->set('Password', ':password')
            ->set('Name', ':name')
            ->set('CompanyName', ':CompanyName')
            ->where('Id = :id')
            ->setParameter('email', $account->getEmail())
            ->setParameter('password', $account->getPassword())
            ->setParameter('name', $account->getName())
            ->setParameter('CompanyName', $account->getCompanyName())
            ->setParameter('id', $account->getId())
            ->executeQuery();

        return $this->findById($account->getId());
    }
}
