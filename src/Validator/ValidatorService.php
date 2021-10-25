<?php

declare(strict_types=1);

namespace ForceVendorCore\Validator;

interface ValidatorService
{
    /**
     * @throws \ForceVendorCore\Exception\HttpBadRequestException
     */
    public function validate(array $data, array $rules): void;
}