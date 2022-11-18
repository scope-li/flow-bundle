<?php

namespace Scopeli\FlowBundle\Event;

use Scopeli\FlowBundle\Element\Activity;

final class ActivityEvents
{
    /**
     * Triggered when a Activity get state "inactive".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const INACTIVE = 'scopeli_flow.activity.inactive';

    /**
     * Triggered when a Activity get state "ready".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const READY = 'scopeli_flow.activity.ready';

    /**
     * Triggered when a Activity get state "active".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const ACTIVE = 'scopeli_flow.activity.active';

    /**
     * Triggered when a Activity get state "completing".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const COMPLETING = 'scopeli_flow.activity.completing';

    /**
     * Triggered when a Activity get state "completed".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const COMPLETED = 'scopeli_flow.activity.completed';

    /**
     * Triggered when a Activity get state "closed".
     *
     * @Event("Scopeli\FlowBundle\Event\ActivityEvent")
     * @var string
     */
    public const CLOSED = 'scopeli_flow.activity.closed';
}
