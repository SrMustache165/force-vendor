<?php

declare(strict_types=1);

namespace ForceVendorCore\Test\Application\Command\RegisterAccount;

use ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountCommand;
use ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountHandler;
use ForceVendorCore\Application\UuidGenerator;
use ForceVendorCore\Domain\Account\Account;
use ForceVendorCore\Domain\Account\AccountRepository;
use ForceVendorCore\Domain\Account\Exception\EmailAlreadyExistsException;
use ForceVendorCore\Domain\Account\Exception\LoginAlreadyExistsException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountHandler
 */
class RegisterAccountHandlerTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::handle
     */
    public function testShouldHandleCommandWithSucess()
    {
        //Arrange 
        $data = $this->getData();

        $command = new RegisterAccountCommand(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['password'],
            $data['CompanyName']
        );

        $repository = $this->createMock(AccountRepository::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->with($this->equalTo($data['email']))
            ->willReturn(null);

        $uuidGenerator = $this->createMock(UuidGenerator::class);
        $uuidGenerator->expects($this->once())
            ->method('generate')
            ->willReturn('cad5e35e-5a6c-47ba-9c15-79082370a09e');

        //Act
        $handler = new RegisterAccountHandler($repository, $uuidGenerator);
        $result = $handler->handle($command);

        //Assert
        $this->assertIsString($result);
    }
    /**
     * @covers ::__construct
     * @covers ::handle
     */
    public function testShouldNotHandleCommandWhenEmailAlreadyExists()
    {
        //Arrange 
        $data = $this->getData();

        $command = new RegisterAccountCommand(
            $data['name'],
            $data['email'],
            $data['login'],
            $data['password'],
            $data['password'],
            $data['phone']
        );

        $account = new Account(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['login'],
            $data['password'],
            $data['phone'],
            0
        );

        $repository = $this->createMock(AccountRepository::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->with($this->equalTo($data['email']))
            ->willReturn($account);

        $uuidGenerator = $this->createMock(UuidGenerator::class);

        //Act
        $handler = new RegisterAccountHandler($repository, $uuidGenerator);

        $this->expectException(EmailAlreadyExistsException::class);
        $this->expectExceptionMessage("Already exists email: '{$data['email']}'");

        $handler->handle($command);
    }

    private function getData()
    {   
        return [
            'id' => 'cad5e35e-5a6c-47ba-9c15-79082370a09e',
            'name' => 'Tester',
            'email' => 'tester@tester.com',
            'password' => 'passwor123',
            'CompanyName' => 'tester'
        ];
    }
}
