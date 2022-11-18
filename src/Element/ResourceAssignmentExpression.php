<?php

namespace Scopeli\FlowBundle\Element;

class ResourceAssignmentExpression extends BaseElement
{
    public function getFormalExpression() : FormalExpression
    {
        $child = $this->getChild('formalExpression');

        assert($child instanceof \DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasFormalExpression() : bool
    {
        return $this->hasChild('formalExpression');
    }
}
