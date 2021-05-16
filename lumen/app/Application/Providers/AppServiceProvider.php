<?php

namespace App\Application\Providers;

use App\Core\Log\LogServiceInterface;
use App\Core\Message\MessageServiceInterface;
use App\Domain\State\ProcessManager\StateRepositoryInterface;
use App\External\Database\StateRepositoryDb;
use App\External\Log\LogService;
use App\External\Message\MessageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LogServiceInterface::class, LogService::class);
        $this->app->bind(MessageServiceInterface::class, MessageService::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepositoryDb::class);
    }
}
