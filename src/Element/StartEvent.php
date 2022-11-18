<?php

namespace Scopeli\FlowBundle\Element;

class StartEvent extends CatchEvent
{
    public function getIsInterrupting() : bool
    {
        $value = $this->getAttribute('isInterrupting') ?? 'true';

        return 'true' === $value;
    }

    public function hasIsInterrupting() : bool
    {
        return $this->hasAttribute('isInterrupting');
    }
}
