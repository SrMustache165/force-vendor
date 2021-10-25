<?php

use ForceVendorCore\Infrastructure\Account\Driving\Http\AccountAction;
use ForceVendorCore\Validator\CreateAccountValidator;

$c = $app->getContainer();

$app->post('/accounts', AccountAction::class . ':register')
    ->add($c->get(CreateAccountValidator::class));

$app->get('/accounts/{account_id}', AccountAction::class . ':find');
