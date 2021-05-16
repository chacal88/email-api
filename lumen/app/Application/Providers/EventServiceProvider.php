<?php

namespace App\Application\Providers;

use App\Domain\State\Event\EmailSent;
use App\Domain\State\Event\EmailStarted;
use App\Domain\State\Event\MailerSelected;
use App\Domain\State\Event\MailerStrategySelected;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EmailStarted::class => [
            'App\Domain\State\ProcessManager\EmailProcessManager@handleEmailStarted',
        ],
        MailerSelected::class => [
            'App\Domain\State\ProcessManager\EmailProcessManager@handleMailerSelected',
        ],
        MailerStrategySelected::class => [
            'App\Domain\State\ProcessManager\EmailProcessManager@handleMailerStrategySelected',
        ],
        EmailSent::class => [
            'App\Domain\State\ProcessManager\EmailProcessManager@handleEmailSent',
        ],
    ];
}
