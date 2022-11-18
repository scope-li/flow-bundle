<?php

namespace Scopeli\FlowBundle\Element;

class ResourceParameterBinding extends BaseElement
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

    public function getParameterRef() : AbstractElement
    {
        $value = $this->getAttribute('parameterRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasParameterRef() : bool
    {
        return $this->hasAttribute('parameterRef');
    }
}
