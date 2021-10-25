<?php

declare(strict_types=1);

namespace ForceVendorCore\Validator;

final class CreateAccountValidator extends Validator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|max:50|min:3',
            'email' => 'required|email',
            'password' => 'required|min:3|max:10',
            'password_confirmation' => 'required|same:password',
            'CompanyName' => 'required'
        ];
    }
}
