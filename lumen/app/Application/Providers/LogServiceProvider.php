<?php

namespace App\Application\Providers;

use App\External\Log\LogService;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the log service.
     *
     * @return void
     */
    public function register()
    {
        $log = $this->app['log'];
        $maxFiles = 5;

        $handlers[] = (new RotatingFileHandler(storage_path("logs/trace.log"), $maxFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));

        $log->setHandlers($handlers);
        $this->app->singleton(
            LogService::class,
            function () use ($log) {
                return new LogService($log);
            }
        );
    }
}
