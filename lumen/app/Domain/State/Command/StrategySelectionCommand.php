<?php

declare(strict_types=1);

namespace App\Domain\State\Command;

use App\Core\Message\CommandInterface;
use App\Domain\State\ReturnsPayload;
use Ramsey\Uuid\UuidInterface;

class StrategySelectionCommand implements CommandInterface
{
    use ReturnsPayload;

    /**
     * @var UuidInterface
     */
    private $aggregateUuid;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $mailer;

    /**
     * StrategySelectionCommand constructor.
     * @param UuidInterface $aggregateUuid
     * @param string $format
     * @param string $mailer
     */
    public function __construct(UuidInterface $aggregateUuid, string $format, string $mailer)
    {
        $this->aggregateUuid = $aggregateUuid;
        $this->format = $format;
        $this->mailer = $mailer;
    }


    public function aggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }
}
