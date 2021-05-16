<?php

namespace App\Application\Providers;

use App\Domain\State\Command\ExecMailerStrategyCommand;
use App\Domain\State\Command\Handler\ExecMailerStrategyHandler;
use App\Domain\State\Command\Handler\MailerSelectionHandler;
use App\Domain\State\Command\Handler\StrategySelectionHandler;
use App\Domain\State\Command\MailerSelectionCommand;
use App\Domain\State\Command\StrategySelectionCommand;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MailerSelectionCommand::class => [
            MailerSelectionHandler::class
        ],
        StrategySelectionCommand::class =>[
            StrategySelectionHandler::class
        ],
        ExecMailerStrategyCommand::class => [
            ExecMailerStrategyHandler::class
        ]
    ];
}
