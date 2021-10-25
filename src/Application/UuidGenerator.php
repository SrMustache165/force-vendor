<?php

declare(strict_types=1);

namespace ForceVendorCore\Application;

interface UuidGenerator
{
    public function generate(): string;
}
