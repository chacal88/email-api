<?php

namespace App\Application\Providers;

use App\Core\Mailer\MailerFactoryInterface;
use App\Core\Mailer\MailerServiceInterface;
use App\External\Mailer\MailerFactory;
use App\External\Mailer\MailerService;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;


class MailerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailerFactoryInterface::class, MailerFactory::class);
        $this->app->bind(MailerServiceInterface::class, MailerService::class);
    }
}
