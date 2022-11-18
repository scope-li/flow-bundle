<?php

namespace Scopeli\FlowBundle\Event;

final class OperationEvents
{
    /**
     * Triggered when a FlowNode with operation is running.
     *
     * @Event("Scopeli\FlowBundle\Event\OperationEvent")
     * @var string
     */
    public const RUN = 'scopeli_flow.operation.run';
}
