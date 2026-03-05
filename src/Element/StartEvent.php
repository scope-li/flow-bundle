<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class StartEvent extends CatchEvent
{
    public function getIsInterrupting(): bool
    {
        return 'true' === ($this->getAttribute('isInterrupting') ?? 'true');
    }

    public function hasIsInterrupting(): bool
    {
        return $this->hasAttribute('isInterrupting');
    }
}
