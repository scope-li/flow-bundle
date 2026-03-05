<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

abstract class FlowElement extends BaseElement
{
    public function getAuditing(): ?Auditing
    {
        $child = $this->getChild('auditing');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Auditing($child, $this->getBpmn());
    }

    public function hasAuditing(): bool
    {
        return $this->hasChild('auditing');
    }

    public function getMonitoring(): ?Monitoring
    {
        $child = $this->getChild('monitoring');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Monitoring($child, $this->getBpmn());
    }

    public function hasMonitoring(): bool
    {
        return $this->hasChild('monitoring');
    }

    /** @return ElementList<AbstractElement> */
    public function getCategoryValueRef(): ElementList
    {
        return new ElementList($this->getRefChilds('categoryValueRef'));
    }

    public function hasCategoryValueRef(): bool
    {
        return $this->hasChild('categoryValueRef');
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
