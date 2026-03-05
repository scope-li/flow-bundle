<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class InterfaceElement extends RootElement
{
    /** @return ElementList<Operation> */
    public function getOperation(): ElementList
    {
        /** @var ElementList<Operation> $elements */
        $elements = new ElementList($this->getChilds('operation'));

        return $elements;
    }

    public function hasOperation(): bool
    {
        return $this->hasChild('operation');
    }

    public function getName(): string
    {
        return (string) $this->getAttribute('name');
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }

    public function getImplementationRef(): ?AbstractElement
    {
        $value = $this->getAttribute('implementationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasImplementationRef(): bool
    {
        return $this->hasAttribute('implementationRef');
    }
}
