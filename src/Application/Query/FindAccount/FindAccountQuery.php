<?php

declare(strict_types=1);

namespace ForceVendorCore\Application\Query\FindAccount;

final class FindAccountQuery
{
    public function __construct(private string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
