<?php

declare(strict_types=1);

namespace App\Domain\State;

use Ramsey\Uuid\UuidInterface;

trait BasicAttributes
{
    /**
     * @var UuidInterface
     */
    private $aggregateUuid;

    /**
     * @var array
     */
    private $payload;

    /**
     * EmailStarted constructor.
     * @param UuidInterface $aggregateUuid
     * @param array $payload
     */
    public function __construct(UuidInterface $aggregateUuid, array $payload)
    {
        $this->aggregateUuid = $aggregateUuid;
        $this->payload = $payload;
    }

    public function aggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}
