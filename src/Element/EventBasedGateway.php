<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class EventBasedGateway extends Gateway
{
    public function getInstantiate(): bool
    {
        return 'true' === ($this->getAttribute('instantiate') ?? 'false');
    }

    public function hasInstantiate(): bool
    {
        return $this->hasAttribute('instantiate');
    }

    public function getEventGatewayType(): string
    {
        return $this->getAttribute('eventGatewayType') ?? 'Exclusive';
    }

    public function hasEventGatewayType(): bool
    {
        return $this->hasAttribute('eventGatewayType');
    }
}
