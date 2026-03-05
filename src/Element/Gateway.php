<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Gateway extends FlowNode
{
    public function getGatewayDirection(): string
    {
        return $this->getAttribute('gatewayDirection') ?? 'Unspecified';
    }

    public function hasGatewayDirection(): bool
    {
        return $this->hasAttribute('gatewayDirection');
    }
}
