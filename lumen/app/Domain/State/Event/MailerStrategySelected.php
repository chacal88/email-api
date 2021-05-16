<?php

declare(strict_types=1);

namespace App\Domain\State\Event;

use App\Core\Message\EventInterface;
use App\Domain\State\BasicAttributes;
use App\Domain\State\ReturnsPayload;
use Ramsey\Uuid\UuidInterface;

class MailerStrategySelected implements EventInterface
{
    use BasicAttributes;
}
