<?php

declare(strict_types=1);

namespace App\Domain\State\Command\Handler;

use App\Core\Log\LogServiceInterface;
use App\Core\Message\CommandHandlerInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\State\Command\MailerSelectionCommand;
use App\Domain\State\Event\MailerSelected;

/**
 * Class StartEmailSendingHandler
 * @package App\Domain\State\Command\Handler
 */
class MailerSelectionHandler implements CommandHandlerInterface
{
    /**
     * @var MessageServiceInterface
     */
    private $eventServiceInterface;

    /**
     * @var LogServiceInterface
     */
    private $logService;

    /**
     * MailerSelectionHandler constructor.
     * @param MessageServiceInterface $eventServiceInterface
     * @param LogServiceInterface $logService
     */
    public function __construct(MessageServiceInterface $eventServiceInterface, LogServiceInterface $logService)
    {
        $this->eventServiceInterface = $eventServiceInterface;
        $this->logService = $logService;
    }

    public function handle(MailerSelectionCommand $command)
    {
        $this->logService->log(' started - ' . $command->aggregateUuid() . ' - ' . MailerSelectionCommand::class);
        $payload = $command->payload();
        $event = new MailerSelected($command->aggregateUuid(), $payload);
        $this->eventServiceInterface->emit($event);
    }

}
