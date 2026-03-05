<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\EventListener;

use Scopeli\FlowBundle\Connector\ConnectorRunner;
use Scopeli\FlowBundle\Event\OperationEvent;

class OperationListener
{
    public function __construct(
        private readonly ConnectorRunner $connectorRunner,
    ) {}

    public function operationRun(OperationEvent $event): void
    {
        $this->connectorRunner->run($event->getActivity(), $event->getProcessInstance());
    }
}
