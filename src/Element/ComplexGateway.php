<?php

namespace Scopeli\FlowBundle\Element;

class ComplexGateway extends Gateway
{
    public function getActivationCondition() : ?Expression
    {
        $child = $this->getChild('activationCondition');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasActivationCondition() : bool
    {
        return $this->hasChild('activationCondition');
    }

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
