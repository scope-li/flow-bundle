<?php

namespace Scopeli\FlowBundle\Element;

class Property extends BaseElement
{
    public function getDataState() : ?DataState
    {
        $child = $this->getChild('dataState');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new DataState($child, $this->getBpmn());
    }

    public function hasDataState() : bool
    {
        return $this->hasChild('dataState');
    }

    public function getName() : ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }

    public function getItemSubjectRef() : ?AbstractElement
    {
        $value = $this->getAttribute('itemSubjectRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasItemSubjectRef() : bool
    {
        return $this->hasAttribute('itemSubjectRef');
    }
}
