<?php

namespace Scopeli\FlowBundle\EventListener;

use Psr\Log\LoggerInterface;
use Scopeli\FlowBundle\Event\ActivityEvent;
use Scopeli\FlowBundle\Event\OperationEvent;
use Scopeli\FlowBundle\Event\ProcessInstanceEvent;

class LoggerListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function loggingProcessInstanceEvent(ProcessInstanceEvent $event): void
    {
        $this->logger->debug(
            sprintf('ProcessInstance => "%s"', $event->getProcessInstance()->getId()),
            $event->getProcessInstance()->getProcessData()
        );
    }

    public function loggingFlowNodeEvent(ActivityEvent $event): void
    {
        $this->logger->debug(
            sprintf('Activity => "%s"', $event->getActivity()->getId()),
            $event->getProcessInstance()->getProcessData()
        );
    }

    public function loggingOperationEvent(OperationEvent $event): void
    {
        $this->logger->debug(
            sprintf('Operation => "%s"', $event->getActivity()->getId()),
            $event->getProcessInstance()->getProcessData()
        );
    }
}
