<?php

namespace Scopeli\FlowBundle\Event;

final class ProcessInstanceEvents
{
    /**
     * Triggered when a ProcessInstance get state "started".
     *
     * @Event("Scopeli\FlowBundle\Event\ProcessInstanceEvent")
     * @var string
     */
    public const STARTED = 'scopeli_flow.process_instance.started';

    /**
     * Triggered when a ProcessInstance get state "ended".
     *
     * @Event("Scopeli\FlowBundle\Event\ProcessInstanceEvent")
     * @var string
     */
    public const ENDED = 'scopeli_flow.process_instance.ended';

    /**
     * Triggered when a ProcessInstance get state "cancelled".
     *
     * @Event("Scopeli\FlowBundle\Event\ProcessInstanceEvent")
     * @var string
     */
    public const CANCELLED = 'scopeli_flow.process_instance.cancelled';

    /**
     * Triggered when a ProcessInstance get state "error".
     *
     * @Event("Scopeli\FlowBundle\Event\ProcessInstanceEvent")
     * @var string
     */
    public const ERROR = 'scopeli_flow.process_instance.error';

    /**
     * Triggered when a ProcessInstance get state "abnormal".
     *
     * @Event("Scopeli\FlowBundle\Event\ProcessInstanceEvent")
     * @var string
     */
    public const ABNORMAL = 'scopeli_flow.process_instance.abnormal';
}
