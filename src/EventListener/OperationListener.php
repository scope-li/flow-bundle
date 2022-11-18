<?php

namespace Scopeli\FlowBundle\EventListener;

use Scopeli\FlowBundle\Event\OperationEvent;
use Scopeli\FlowBundle\Connector\ConnectorRunner;

class OperationListener
{
    private ConnectorRunner $connectorRunner;

    public function __construct(ConnectorRunner $connectorRunner)
    {
        $this->connectorRunner = $connectorRunner;
    }

    public function operationRun(OperationEvent $event): void
    {
        $this->connectorRunner->run($event->getActivity(), $event->getProcessInstance());
    }
}
