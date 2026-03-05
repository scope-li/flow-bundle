<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Event;

final class ProcessInstanceEvents
{
    public const string STARTED = 'scopeli_flow.process_instance.started';

    public const string ENDED = 'scopeli_flow.process_instance.ended';

    public const string CANCELLED = 'scopeli_flow.process_instance.cancelled';

    public const string ERROR = 'scopeli_flow.process_instance.error';

    public const string ABNORMAL = 'scopeli_flow.process_instance.abnormal';
}
