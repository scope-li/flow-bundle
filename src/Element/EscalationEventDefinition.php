<?php

namespace Scopeli\FlowBundle\Element;

class EscalationEventDefinition extends EventDefinition
{
    public function getEscalationRef() : ?AbstractElement
    {
        $value = $this->getAttribute('escalationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasEscalationRef() : bool
    {
        return $this->hasAttribute('escalationRef');
    }
}
