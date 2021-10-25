<?php

declare(strict_types=1);

namespace ForceVendorCore\Infrastructure\Application;

use ForceVendorCore\Application\UuidGenerator;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
