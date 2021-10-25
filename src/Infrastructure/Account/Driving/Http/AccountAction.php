<?php

declare(strict_types=1);

namespace ForceVendorCore\Infrastructure\Account\Driving\Http;

use Exception;
use Fig\Http\Message\StatusCodeInterface as HttpCode;
use ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountCommand;
use ForceVendorCore\Application\Command\RegisterAccount\RegisterAccountHandler;
use ForceVendorCore\Application\Query\FindAccount\FindAccountHandler;
use ForceVendorCore\Application\Query\FindAccount\FindAccountQuery;
use ForceVendorCore\Domain\Account\Exception\AccountNotFoundException;
use ForceVendorCore\Domain\Account\Exception\EmailAlreadyExistsException;
use ForceVendorCore\Domain\Account\Exception\LoginAlreadyExistsException;
use ForceVendorCore\Exception\HttpException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ForceVendorCore\Infrastructure\Shared\Driving\Http\HttpResponseBehavior;

final class AccountAction
{
    use HttpResponseBehavior;

    public function __construct(
        private RegisterAccountHandler $registerAccountHandler,
        private FindAccountHandler $findAccountHandler
    ) {
        $this->registerAccountHandler = $registerAccountHandler;
        $this->findAccountHandler = $findAccountHandler;
    }

    public function register(Request $request): Response
    {
        try {
            $body = $request->getParsedBody();

            $command = new RegisterAccountCommand(
                $body['name'],
                $body['email'],
                $body['password'],
                $body['password_confirmation'],
                $body['CompanyName']
            );

            $id = $this->registerAccountHandler->handle($command);

            return $this->respond(['id' => $id], HttpCode::STATUS_CREATED);
        } catch (LoginAlreadyExistsException $ex) {
            $this->handleBadRequestException($ex);
        } catch (EmailAlreadyExistsException $ex) {
            $this->handleBadRequestException($ex);
        }
    }

    public function find(Request $request): Response
    {
        try {
            $id = $request->getAttribute('account_id');

            $query = new FindAccountQuery($id);

            $account = $this->findAccountHandler->handle($query);

            return $this->respond($account->toArray(), HttpCode::STATUS_OK);
        } catch (AccountNotFoundException $ex) {
            $this->handleBadRequestException($ex);
        }
    }

    private function handleBadRequestException(Exception $ex)
    {
        throw new HttpException($ex->getMessage(), HttpCode::STATUS_BAD_REQUEST);
    }
}
