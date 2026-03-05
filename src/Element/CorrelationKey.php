<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class CorrelationKey extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getCorrelationPropertyRef(): ElementList
    {
        return new ElementList($this->getRefChilds('correlationPropertyRef'));
    }

    public function hasCorrelationPropertyRef(): bool
    {
        return $this->hasChild('correlationPropertyRef');
    }

    public function getName(): ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }
}
