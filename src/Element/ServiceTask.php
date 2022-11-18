<?php

namespace Scopeli\FlowBundle\Element;

class ServiceTask extends Task
{
    public function getImplementation() : string
    {
        $value = $this->getAttribute('implementation') ?? '##WebService';

        return (string) $value;
    }

    public function hasImplementation() : bool
    {
        return $this->hasAttribute('implementation');
    }

    public function getOperationRef() : ?AbstractElement
    {
        $value = $this->getAttribute('operationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasOperationRef() : bool
    {
        return $this->hasAttribute('operationRef');
    }
}
