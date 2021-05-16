<?php

declare(strict_types=1);

namespace App\Core\Message;

use Ramsey\Uuid\UuidInterface;

interface MessageInterface
{
    public function aggregateUuid(): UuidInterface;

    public function payload(): array;
}
