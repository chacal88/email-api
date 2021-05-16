<?php

declare(strict_types=1);

namespace App\Domain\State\Command\Handler;

use App\Core\Log\LogServiceInterface;
use App\Core\Mailer\MailerServiceInterface;
use App\Core\Message\CommandHandlerInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\State\Command\StrategySelectionCommand;
use App\Domain\State\Event\MailerStrategySelected;

/**
 * Class StartEmailSendingHandler
 * @package App\Domain\State\Command\Handler
 */
class StrategySelectionHandler implements CommandHandlerInterface
{
    /**
     * @var MessageServiceInterface
     */
    private $eventServiceInterface;

    /**
     * @var MailerServiceInterface
     */
    private $mailerService;

    /**
     * @var LogServiceInterface
     */
    private $logService;

    /**
     * StrategySelectionHandler constructor.
     * @param MessageServiceInterface $eventServiceInterface
     * @param MailerServiceInterface $mailerService
     * @param LogServiceInterface $logService
     */
    public function __construct(
        MessageServiceInterface $eventServiceInterface,
        MailerServiceInterface $mailerService,
        LogServiceInterface $logService
    ) {
        $this->eventServiceInterface = $eventServiceInterface;
        $this->mailerService = $mailerService;
        $this->logService = $logService;
    }

    public function handle(StrategySelectionCommand $command)
    {
        $this->logService->log(' started - ' . $command->aggregateUuid() . ' - ' . StrategySelectionCommand::class);
        $mailer = $command->payload()['mailer'];
        $format = $command->payload()['format'];
        $payload['strategy'] = $this->mailerService->listStrategy($mailer)[$format];
        $event = new MailerStrategySelected($command->aggregateUuid(), $payload);
        $this->eventServiceInterface->emit($event);
    }

}
