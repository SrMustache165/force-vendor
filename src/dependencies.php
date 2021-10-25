<?php

declare(strict_types=1);

use DI\Container;
use Doctrine\DBAL\Connection;
use ForceVendorCore\Application\UuidGenerator;
use ForceVendorCore\DAO\AccountDAO;
use ForceVendorCore\DAO\MsSQLAccountDAO;
use ForceVendorCore\DAO\TransactionDAO;
use ForceVendorCore\DAO\MsSQLTransactionDAO;
use ForceVendorCore\Domain\Account\AccountRepository;
use ForceVendorCore\Infrastructure\Account\Driven\Database\MsSQLAccountRepository;
use ForceVendorCore\Infrastructure\Application\RamseyUuidGenerator;
use ForceVendorCore\Validator\IlluminateValidatorService;
use ForceVendorCore\Validator\ValidatorService;

$dependencies = [
    Connection::class => function (Container $c) {
        $connectionParams = array(
            'dbname' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'host' => getenv('DB_HOST'),
            'driver' => getenv('DB_DRIVER'),
        );

        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
    },

    AccountDAO::class => function (Container $c) {
        return new MsSQLAccountDAO($c->get(Connection::class));
    },

    TransactionDAO::class => function (Container $c) {
        return new MsSQLTransactionDAO($c->get(Connection::class));
    },

    ValidatorService::class => function (Container $c) {
        return new IlluminateValidatorService();
    },

    AccountRepository::class => function (Container $c) {
        return new MsSQLAccountRepository($c->get(Connection::class));
    },

    UuidGenerator::class => function (Container $c) {
        return new RamseyUuidGenerator();
    }
];
