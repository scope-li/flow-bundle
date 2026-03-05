<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class CorrelationSubscription extends BaseElement
{
    /** @return ElementList<CorrelationPropertyBinding> */
    public function getCorrelationPropertyBinding(): ElementList
    {
        /** @var ElementList<CorrelationPropertyBinding> $elements */
        $elements = new ElementList($this->getChilds('correlationPropertyBinding'));

        return $elements;
    }

    public function hasCorrelationPropertyBinding(): bool
    {
        return $this->hasChild('correlationPropertyBinding');
    }

    public function getCorrelationKeyRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('correlationKeyRef'));
    }

    public function hasCorrelationKeyRef(): bool
    {
        return $this->hasAttribute('correlationKeyRef');
    }
}
