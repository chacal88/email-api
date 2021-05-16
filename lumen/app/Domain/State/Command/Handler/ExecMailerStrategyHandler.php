<?php

declare(strict_types=1);

namespace App\Domain\State\Command\Handler;

use App\Core\Log\LogServiceInterface;
use App\Core\Mailer\MailerException;
use App\Core\Mailer\MailerFactoryInterface;
use App\Core\Message\CommandHandlerInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\Mailer\EmailToSend;
use App\Domain\State\Command\ExecMailerStrategyCommand;
use App\Domain\State\Event\EmailSent;
use Ramsey\Uuid\Uuid;

/**
 * Class StartEmailSendingHandler
 * @package App\Domain\State\Command\Handler
 */
class ExecMailerStrategyHandler implements CommandHandlerInterface
{
    /**
     * @var MessageServiceInterface
     */
    private $eventServiceInterface;

    /**
     * @var MailerFactoryInterface
     */
    private $mailerFactory;
    /**
     * @var LogServiceInterface
     */
    private $logService;

    /**
     * ExecMailerStrategyHandler constructor.
     * @param MessageServiceInterface $eventServiceInterface
     * @param MailerFactoryInterface $mailerFactory
     * @param LogServiceInterface $logService
     */
    public function __construct(
        MessageServiceInterface $eventServiceInterface,
        MailerFactoryInterface $mailerFactory,
        LogServiceInterface $logService
    ) {
        $this->eventServiceInterface = $eventServiceInterface;
        $this->mailerFactory = $mailerFactory;
        $this->logService = $logService;
    }


    public function handle(ExecMailerStrategyCommand $command)
    {
        $this->logService->log(' started - ' . $command->aggregateUuid() . ' - ' . ExecMailerStrategyCommand::class);

        $mailer = $command->payload()['mailer'];
        $mailerStrategy = $command->payload()['strategy'];
        $emailToSend = $command->payload()['emailToSend'];
        $mailerBuilt = $this->mailerFactory->build($mailer, $mailerStrategy);


        $emailToSendObject = new EmailToSend(
            Uuid::fromString($emailToSend['uuid']),
            $emailToSend['from'],
            $emailToSend['to'],
            $emailToSend['cc'],
            $emailToSend['subject'],
            $emailToSend['body'],
            $emailToSend['format']
        );
        try {
            $sent = $mailerBuilt->send($emailToSendObject);
        } catch (MailerException $exception) {
            $sent = false;
        }
        $payload['isSent'] = $sent;
        $payload['mailer'] = $mailer;
        $event = new EmailSent($command->aggregateUuid(), $payload);
        $this->eventServiceInterface->emit($event);
    }
}
