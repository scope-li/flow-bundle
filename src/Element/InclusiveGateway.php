<?php

namespace Scopeli\FlowBundle\Element;

class InclusiveGateway extends Gateway
{
    public function getDefault() : ?AbstractElement
    {
        $value = $this->getAttribute('default');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasDefault() : bool
    {
        return $this->hasAttribute('default');
    }
}
