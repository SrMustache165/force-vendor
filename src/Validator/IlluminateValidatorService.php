<?php

declare(strict_types=1);

namespace ForceVendorCore\Validator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use ForceVendorCore\Exception\HttpBadRequestException;

final class IlluminateValidatorService implements ValidatorService
{
    private const MESSAGES = [
        'required' => 'Field is required',
        'min' => 'Field length must be greater or equals than :min',
        'max' => 'Field length must be less or equals than :max',
        'string' => 'Field must be string',
        'int' => 'Field must be int',
        'email' => 'Field must be a valid email address',
        'same' => 'Field do not match with :attribute'
    ];

    public function validate(array $data, array $rules): void
    {
        $filesystem = new Filesystem();
        $fileLoader = new FileLoader($filesystem, '');
        $translator = new Translator($fileLoader, 'en_US');
        $factory = new Factory($translator);

        $validator = $factory->make($data, $rules, self::MESSAGES);

        if ($validator->fails()) {
            $errorMessages = [];

            $errors = $validator->errors();

            foreach ($errors->getMessages() as $path => $messages) {
                foreach ($messages as $message) {
                    $errorMessages['errors'][] = [
                        'path' => $path,
                        'message' => $message
                    ];
                }
            }
            
            throw new HttpBadRequestException($errorMessages);
        }
    }
}