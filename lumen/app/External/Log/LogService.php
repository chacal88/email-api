<?php


namespace App\External\Log;


use App\Core\Log\LogServiceInterface;
use Illuminate\Log\Logger;
use Illuminate\Log\LogManager;

class LogService implements LogServiceInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * LogService constructor.
     * @param LogManager $log
     */
    public function __construct(LogManager $log)
    {
        $this->logger = $log;
    }


    public function log(string $text)
    {
        $this->logger->info($text);
    }
}
