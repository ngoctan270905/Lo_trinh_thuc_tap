<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerService
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('custom');
        $this->logger->pushHandler(new StreamHandler(storage_path('logs/custom.log'), Logger::DEBUG));
    }

    public function log($message)
    {
        $this->logger->info($message);
    }
}
