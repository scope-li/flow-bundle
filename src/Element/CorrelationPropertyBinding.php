<?php

namespace Scopeli\FlowBundle\Element;

class CorrelationPropertyBinding extends BaseElement
{
    public function getDataPath() : FormalExpression
    {
        $child = $this->getChild('dataPath');

        assert($child instanceof \DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasDataPath() : bool
    {
        return $this->hasChild('dataPath');
    }

    public function getCorrelationPropertyRef() : AbstractElement
    {
        $value = $this->getAttribute('correlationPropertyRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCorrelationPropertyRef() : bool
    {
        return $this->hasAttribute('correlationPropertyRef');
    }
}
