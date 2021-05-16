<?php

declare(strict_types=1);

namespace App\Domain\State\Command;

use App\Core\Message\CommandInterface;
use App\Domain\State\ReturnsPayload;
use Ramsey\Uuid\UuidInterface;

class MailerSelectionCommand implements CommandInterface
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
     * MailerSelectionCommand constructor.
     * @param UuidInterface $aggregateUuid
     * @param $mailer
     */
    public function __construct(UuidInterface $aggregateUuid, $mailer)
    {
        $this->aggregateUuid = $aggregateUuid;
        $this->mailer = $mailer;
    }


    public function aggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function payload(): array
    {
        return [
            'aggregateUuid' => $this->aggregateUuid(),
            'mailer'        => $this->mailer
        ];
    }
}
