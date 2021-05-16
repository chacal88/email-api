<?php

namespace App\Core\Message;

use DateTime;
use Ramsey\Uuid\UuidInterface;

interface StateInterface
{
    /**
     * @return UuidInterface
     */
    public function getProcessUuid(): UuidInterface;

    /**
     * @return array
     */
    public function getPayload(): array;

    /**
     * @return array
     */
    public function getPhases(): array;

    /**
     * @return DateTime
     */
    public function getMarkedAsDoneAt(): ?DateTime;

}
