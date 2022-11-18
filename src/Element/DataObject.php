<?php

namespace Scopeli\FlowBundle\Element;

class DataObject extends FlowElement
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

    public function getIsCollection() : bool
    {
        $value = $this->getAttribute('isCollection') ?? 'false';

        return 'true' === $value;
    }

    public function hasIsCollection() : bool
    {
        return $this->hasAttribute('isCollection');
    }
}
