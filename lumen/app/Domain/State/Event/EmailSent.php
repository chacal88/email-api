<?php

declare(strict_types=1);

namespace App\Domain\State\Event;

use App\Core\Message\EventInterface;
use App\Domain\State\BasicAttributes;

class EmailSent implements EventInterface
{
    use BasicAttributes;
}
