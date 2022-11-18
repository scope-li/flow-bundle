<?php

namespace Scopeli\FlowBundle\Element;

class InterfaceElement extends RootElement
{
    /** @return ElementList<Operation> */
    public function getOperation() : ElementList
    {
        /** @var ElementList<Operation> $elements */
        $elements = new ElementList($this->getChilds('operation'));

        return $elements;
    }

    public function hasOperation() : bool
    {
        return $this->hasChild('operation');
    }

    public function getName() : string
    {
        $value = $this->getAttribute('name');

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }

    public function getImplementationRef() : ?AbstractElement
    {
        $value = $this->getAttribute('implementationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasImplementationRef() : bool
    {
        return $this->hasAttribute('implementationRef');
    }
}
