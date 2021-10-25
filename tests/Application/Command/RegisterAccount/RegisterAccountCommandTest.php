<?php

declare(strict_types=1);

namespace ForceVendorCore\Test\Application\Command\RegisterAccount;

use ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountCommand;
use PHPUnit\Framework\TestCase;

class RegisterAccountCommandTest extends TestCase
{
    public function testShouldBuildCommand()
    {
        $data = [
            'name' => 'Tester',
            'email' => 'tester@tester.com',
            'password' => 'password123',
            'CompanyName' => 'CompanyName'
        ];

        $command = new RegisterAccountCommand(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['password'],
            $data['CompanyName']
        );

        $this->assertEquals($data['name'], $command->getName());
        $this->assertEquals($data['email'], $command->getEmail());
        $this->assertEquals($data['password'], $command->getPassword());
        $this->assertEquals($data['password'], $command->getPasswordConfirmation());
        $this->assertEquals($data['CompanyName'], $command->getCompanyName());
    }
}
