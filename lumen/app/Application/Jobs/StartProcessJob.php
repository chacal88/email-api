<?php

namespace App\Application\Jobs;

use App\Core\Log\LogServiceInterface;
use App\Core\Mailer\EmailToSendInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\State\Event\EmailStarted;
use Ramsey\Uuid\UuidInterface;

/**
 * Class StartProcessJob
 * @package App\Domain\Job
 */
class StartProcessJob extends Job
{

    /**
     * @var EmailToSendInterface
     */
    public $emailToSend;

    /**
     * StartProcessJob constructor.
     * @param EmailToSendInterface $emailToSend
     * @param UuidInterface $stateUuid
     */
    public function __construct(EmailToSendInterface $emailToSend)
    {
        $this->emailToSend = $emailToSend;
    }

    public function handle(MessageServiceInterface $messageService, LogServiceInterface $logService)
    {
        $logService->log('StartProcessJob started - ' . $this->aggregateUuid());
        $messageService->emit(new EmailStarted($this->aggregateUuid(), $this->payload()));
    }


    public function aggregateUuid(): UuidInterface
    {
        return $this->emailToSend->getUuid();
    }

    public function payload(): array
    {
        return [
            'aggregateUuid' => $this->emailToSend->getUuid(),
            'emailToSend'   => $this->emailToSend->toArray()
        ];
    }
}
