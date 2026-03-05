<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class CallableElement extends RootElement
{
    /** @return ElementList<AbstractElement> */
    public function getSupportedInterfaceRef(): ElementList
    {
        return new ElementList($this->getRefChilds('supportedInterfaceRef'));
    }

    public function hasSupportedInterfaceRef(): bool
    {
        return $this->hasChild('supportedInterfaceRef');
    }

    public function getIoSpecification(): ?IoSpecification
    {
        $child = $this->getChild('ioSpecification');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new IoSpecification($child, $this->getBpmn());
    }

    public function hasIoSpecification(): bool
    {
        return $this->hasChild('ioSpecification');
    }

    /** @return ElementList<IoBinding> */
    public function getIoBinding(): ElementList
    {
        /** @var ElementList<IoBinding> $elements */
        $elements = new ElementList($this->getChilds('ioBinding'));

        return $elements;
    }

    public function hasIoBinding(): bool
    {
        return $this->hasChild('ioBinding');
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
