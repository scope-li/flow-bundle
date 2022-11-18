<?php

namespace Scopeli\FlowBundle\Element;

class CorrelationSubscription extends BaseElement
{
    /** @return ElementList<CorrelationPropertyBinding> */
    public function getCorrelationPropertyBinding() : ElementList
    {
        /** @var ElementList<CorrelationPropertyBinding> $elements */
        $elements = new ElementList($this->getChilds('correlationPropertyBinding'));

        return $elements;
    }

    public function hasCorrelationPropertyBinding() : bool
    {
        return $this->hasChild('correlationPropertyBinding');
    }

    public function getCorrelationKeyRef() : AbstractElement
    {
        $value = $this->getAttribute('correlationKeyRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCorrelationKeyRef() : bool
    {
        return $this->hasAttribute('correlationKeyRef');
    }
}
