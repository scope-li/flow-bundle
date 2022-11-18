<?php

namespace Scopeli\FlowBundle\Element;

class InputSet extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getDataInputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('dataInputRefs'));
    }

    public function hasDataInputRefs() : bool
    {
        return $this->hasChild('dataInputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getOptionalInputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('optionalInputRefs'));
    }

    public function hasOptionalInputRefs() : bool
    {
        return $this->hasChild('optionalInputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getWhileExecutingInputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('whileExecutingInputRefs'));
    }

    public function hasWhileExecutingInputRefs() : bool
    {
        return $this->hasChild('whileExecutingInputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getOutputSetRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('outputSetRefs'));
    }

    public function hasOutputSetRefs() : bool
    {
        return $this->hasChild('outputSetRefs');
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
}
