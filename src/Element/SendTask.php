<?php

namespace Scopeli\FlowBundle\Element;

class SendTask extends Task
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

    public function getMessageRef() : ?AbstractElement
    {
        $value = $this->getAttribute('messageRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasMessageRef() : bool
    {
        return $this->hasAttribute('messageRef');
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
