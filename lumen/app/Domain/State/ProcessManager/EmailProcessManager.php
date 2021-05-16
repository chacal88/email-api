<?php

declare(strict_types=1);

namespace App\Domain\State\ProcessManager;

use App\Core\Log\LogServiceInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\State\Command\ExecMailerStrategyCommand;
use App\Domain\State\Command\MailerSelectionCommand;
use App\Domain\State\Command\StrategySelectionCommand;
use App\Domain\State\Event\EmailSent;
use App\Domain\State\Event\EmailStarted;
use App\Domain\State\Event\MailerSelected;
use App\Domain\State\Event\MailerStrategySelected;
use App\External\Mailer\MailJetMailer\MailJetMailer;
use App\External\Mailer\SendGridMailer\SendGridMailer;

class EmailProcessManager
{

    /**
     * @var LogServiceInterface
     */
    private $logService;

    /**
     * @var MessageServiceInterface
     */
    private $messageService;

    /** @var StateRepositoryInterface */
    private $stateRepository;

    /**
     * EmailProcessManager constructor.
     * @param LogServiceInterface $logService
     * @param MessageServiceInterface $messageService
     * @param StateRepositoryInterface $stateRepository
     */
    public function __construct(
        LogServiceInterface $logService,
        MessageServiceInterface $messageService,
        StateRepositoryInterface $stateRepository
    ) {
        $this->logService = $logService;
        $this->messageService = $messageService;
        $this->stateRepository = $stateRepository;
    }

    public function handleEmailStarted(EmailStarted $eventReceived): void
    {
        $this->logService->log('handleEmailStarted' . ' - ' . $eventReceived->aggregateUuid() . ' - ' . EmailStarted::class);
        $aggregateUuid = $eventReceived->aggregateUuid();
        $this->stateRepository->save(State::start($aggregateUuid, $eventReceived->payload(), EmailStarted::class));
        $command = new MailerSelectionCommand($aggregateUuid, SendGridMailer::class);
        $this->messageService->emit($command);
        $this->logService->log('command emitted' . ' - ' . $aggregateUuid . ' - ' . MailerSelectionCommand::class);
    }

    public function handleMailerSelected(MailerSelected $eventReceived): void
    {
        $this->logService->log('handleMailerSelected - ' . $eventReceived->aggregateUuid() . ' - ' . MailerSelected::class);
        $aggregateUuid = $eventReceived->aggregateUuid();
        $state = $this->stateRepository->find($aggregateUuid);
        if (null === $state) {
            $this->logService->log('state not found - ' . $eventReceived->aggregateUuid());
            return;
        }
        $this->stateRepository->save($state->apply($eventReceived->payload(), MailerSelected::class));
        $format = $state->getPayload()['emailToSend']['format'];
        $mailer = $state->getPayload()['mailer'];
        $command = new StrategySelectionCommand($aggregateUuid, $format, $mailer);
        $this->messageService->emit($command);
        $this->logService->log('command emitted' . ' - ' . $aggregateUuid . ' - ' . StrategySelectionCommand::class);
    }

    public function handleMailerStrategySelected(MailerStrategySelected $eventReceived): void
    {
        $this->logService->log('handleMailerStrategySelected - ' . $eventReceived->aggregateUuid() . ' - ' . MailerStrategySelected::class);
        $aggregateUuid = $eventReceived->aggregateUuid();
        $state = $this->stateRepository->find($aggregateUuid);
        if (null === $state) {
            $this->logService->log('state not found' . ' - ' . $eventReceived->aggregateUuid());
            return;
        }
        $this->stateRepository->save($state->apply($eventReceived->payload(), MailerStrategySelected::class));
        $mailer = $state->getPayload()['mailer'];
        $strategy = $state->getPayload()['strategy'];
        $emailToSend = $state->getPayload()['emailToSend'];
        $command = new ExecMailerStrategyCommand($aggregateUuid, $mailer, $strategy, $emailToSend);
        $this->messageService->emit($command);
        $this->logService->log('command emitted' . ' - ' . $aggregateUuid . ' - ' . ExecMailerStrategyCommand::class);
    }

    public function handleEmailSent(EmailSent $eventReceived): void
    {
        $this->logService->log('handleEmailSent - ' . $eventReceived->aggregateUuid() . ' - ' . EmailSent::class);
        $aggregateUuid = $eventReceived->aggregateUuid();
        $eventPayload = $eventReceived->payload();
        $state = $this->stateRepository->find($aggregateUuid);
        if (null === $state) {
            $this->logService->log('state not found' . ' - ' . $eventReceived->aggregateUuid());
            return;
        }

        $lastMailer = $eventPayload['mailer'];
        $mailersUsed = !empty($state->getPayload()['mailersUsed']) ? $state->getPayload()['mailersUsed'] : [];
        $eventPayload['mailersUsed'] = array_merge($mailersUsed, [$eventPayload['mailer']]);
        $eventPayload['mailer'] = '';
        $eventPayload['strategy'] = '';

        $this->stateRepository->save($state->apply($eventPayload, EmailSent::class));

        if (!empty($eventPayload['isSent'])) {
            $this->stateRepository->save($state->done());
            return;
        }

        if ($lastMailer === SendGridMailer::class) {
            $command = new MailerSelectionCommand($aggregateUuid, MailJetMailer::class);
            $this->messageService->emit($command);
            $this->logService->log('command emitted' . ' - ' . $aggregateUuid . ' - ' . MailerSelectionCommand::class);
        }
    }
}
