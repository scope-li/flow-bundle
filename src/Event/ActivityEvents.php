<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Event;

final class ActivityEvents
{
    public const string INACTIVE = 'scopeli_flow.activity.inactive';

    public const string READY = 'scopeli_flow.activity.ready';

    public const string ACTIVE = 'scopeli_flow.activity.active';

    public const string COMPLETING = 'scopeli_flow.activity.completing';

    public const string COMPLETED = 'scopeli_flow.activity.completed';

    public const string CLOSED = 'scopeli_flow.activity.closed';
}
