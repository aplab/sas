<?php namespace App\EventListener;
use App\Component\SystemState\SystemStateManager;
use Psr\Log\LoggerInterface;

class TerminateListener
{
    private SystemStateManager $systemStateManager;

    private LoggerInterface $logger;

    public function __construct(SystemStateManager $systemStateManager, LoggerInterface $logger)
    {
        $this->systemStateManager = $systemStateManager;
        $this->logger = $logger;
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function onKernelTerminate($event)
    {
        $this->systemStateManager->flush($this->logger);
    }
}
