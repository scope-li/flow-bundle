<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class EscalationEventDefinition extends EventDefinition
{
    public function getEscalationRef(): ?AbstractElement
    {
        $value = $this->getAttribute('escalationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasEscalationRef(): bool
    {
        return $this->hasAttribute('escalationRef');
    }
}
