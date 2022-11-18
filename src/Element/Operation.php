<?php

namespace Scopeli\FlowBundle\Element;

class Operation extends BaseElement
{
    public function getInMessageRef() : AbstractElement
    {
        $child = $this->getChild('inMessageRef');

        assert($child instanceof \DOMElement);
        return self::createElement($child, $this->getBpmn());
    }

    public function hasInMessageRef() : bool
    {
        return $this->hasChild('inMessageRef');
    }

    public function getOutMessageRef() : ?AbstractElement
    {
        $child = $this->getChild('outMessageRef');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasOutMessageRef() : bool
    {
        return $this->hasChild('outMessageRef');
    }

    /** @return ElementList<AbstractElement> */
    public function getErrorRef() : ElementList
    {
        return new ElementList($this->getRefChilds('errorRef'));
    }

    public function hasErrorRef() : bool
    {
        return $this->hasChild('errorRef');
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
