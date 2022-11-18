<?php

namespace Scopeli\FlowBundle\Element;

class ComplexBehaviorDefinition extends BaseElement
{
    public function getCondition() : FormalExpression
    {
        $child = $this->getChild('condition');

        assert($child instanceof \DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasCondition() : bool
    {
        return $this->hasChild('condition');
    }

    public function getEvent() : ?ImplicitThrowEvent
    {
        $child = $this->getChild('event');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new ImplicitThrowEvent($child, $this->getBpmn());
    }

    public function hasEvent() : bool
    {
        return $this->hasChild('event');
    }
}
