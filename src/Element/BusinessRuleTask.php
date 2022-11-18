<?php

namespace Scopeli\FlowBundle\Element;

class BusinessRuleTask extends Task
{
    public function getImplementation() : string
    {
        $value = $this->getAttribute('implementation') ?? '##unspecified';

        return (string) $value;
    }

    public function hasImplementation() : bool
    {
        return $this->hasAttribute('implementation');
    }
}
