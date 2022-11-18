<?php

namespace Scopeli\FlowBundle\Element;

class SignalEventDefinition extends EventDefinition
{
    public function getSignalRef() : ?AbstractElement
    {
        $value = $this->getAttribute('signalRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasSignalRef() : bool
    {
        return $this->hasAttribute('signalRef');
    }
}
