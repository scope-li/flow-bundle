<?php

namespace Scopeli\FlowBundle\Element;

class ErrorEventDefinition extends EventDefinition
{
    public function getErrorRef() : ?AbstractElement
    {
        $value = $this->getAttribute('errorRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasErrorRef() : bool
    {
        return $this->hasAttribute('errorRef');
    }
}
