<?php

namespace Scopeli\FlowBundle\Element;

class EventBasedGateway extends Gateway
{
    public function getInstantiate() : bool
    {
        $value = $this->getAttribute('instantiate') ?? 'false';

        return 'true' === $value;
    }

    public function hasInstantiate() : bool
    {
        return $this->hasAttribute('instantiate');
    }

    public function getEventGatewayType() : string
    {
        $value = $this->getAttribute('eventGatewayType') ?? 'Exclusive';

        return (string) $value;
    }

    public function hasEventGatewayType() : bool
    {
        return $this->hasAttribute('eventGatewayType');
    }
}
