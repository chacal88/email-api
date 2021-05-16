<?php

declare(strict_types=1);

namespace App\Domain\State\ProcessManager;

use App\Core\Message\StateInterface;
use DateTime;
use DomainException;
use Ramsey\Uuid\UuidInterface;

class State implements StateInterface
{
    /** @var UuidInterface */
    private $processUuid;

    /** @var array */
    private $payload;

    /**
     * @var []
     */
    private $phases;

    /** @var DateTime */
    private $markedAsDoneAt;

    public function __construct(UuidInterface $processUuid, array $payload, array $phases, ?DateTime $markedAsDoneAt)
    {
        $this->payload        = $payload;
        $this->processUuid    = $processUuid;
        $this->phases         = $phases;
        $this->markedAsDoneAt = $markedAsDoneAt;
    }

    public static function start(UuidInterface $processUuid, array $payload, $phase): self
    {
        return new self($processUuid, $payload, [$phase], null);
    }

    public function apply(array $payload,$phase): self
    {
        if ($this->markedAsDoneAt instanceof DateTime) {
            throw new DomainException('Can not modify state when its done');
        }

        $this->payload = array_merge($this->payload, $payload);
        $this->phases = array_merge($this->phases, [$phase]);

        return new self($this->processUuid, $this->payload,$this->phases, $this->markedAsDoneAt);
    }

    public function done(): self
    {
        return new self($this->processUuid, $this->payload,$this->phases, new DateTime());
    }

    /**
     * @return UuidInterface
     */
    public function getProcessUuid(): UuidInterface
    {
        return $this->processUuid;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @return DateTime
     */
    public function getMarkedAsDoneAt(): ?DateTime
    {
        return $this->markedAsDoneAt;
    }

    /**
     * @return mixed
     */
    public function getPhases(): array
    {
        return $this->phases;
    }
}
