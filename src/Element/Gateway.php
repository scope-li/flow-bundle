<?php

namespace Scopeli\FlowBundle\Element;

class Gateway extends FlowNode
{
    public function getGatewayDirection() : string
    {
        $value = $this->getAttribute('gatewayDirection') ?? 'Unspecified';

        return (string) $value;
    }

    public function hasGatewayDirection() : bool
    {
        return $this->hasAttribute('gatewayDirection');
    }
}
