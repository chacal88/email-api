<?php

declare(strict_types=1);

namespace App\Domain\State\Command;

use App\Core\Message\CommandInterface;
use Ramsey\Uuid\UuidInterface;

class ExecMailerStrategyCommand implements CommandInterface
{
    /**
     * @var UuidInterface
     */
    private $aggregateUuid;

    /**
     * @var string
     */
    private $mailer;

    /**
     * @var string
     */
    private $strategy;

    /**
     * @var []
     */
    private $emailToSend;

    /**
     * ExecMailerStrategyCommand constructor.
     * @param UuidInterface $aggregateUuid
     * @param string $mailer
     * @param string $strategy
     * @param array $emailToSend
     */
    public function __construct(
        UuidInterface $aggregateUuid,
        string $mailer,
        string $strategy,
        array $emailToSend
    ) {
        $this->aggregateUuid = $aggregateUuid;
        $this->mailer = $mailer;
        $this->strategy = $strategy;
        $this->emailToSend = $emailToSend;
    }


    public function aggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function payload(): array
    {
        return [
            'aggregateUuid' => $this->aggregateUuid,
            'mailer'        => $this->mailer,
            'strategy'      => $this->strategy,
            'emailToSend'   => $this->emailToSend,
        ];
    }


}
