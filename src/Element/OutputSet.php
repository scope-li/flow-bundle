<?php

namespace Scopeli\FlowBundle\Element;

class OutputSet extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getDataOutputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('dataOutputRefs'));
    }

    public function hasDataOutputRefs() : bool
    {
        return $this->hasChild('dataOutputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getOptionalOutputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('optionalOutputRefs'));
    }

    public function hasOptionalOutputRefs() : bool
    {
        return $this->hasChild('optionalOutputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getWhileExecutingOutputRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('whileExecutingOutputRefs'));
    }

    public function hasWhileExecutingOutputRefs() : bool
    {
        return $this->hasChild('whileExecutingOutputRefs');
    }

    /** @return ElementList<AbstractElement> */
    public function getInputSetRefs() : ElementList
    {
        return new ElementList($this->getRefChilds('inputSetRefs'));
    }

    public function hasInputSetRefs() : bool
    {
        return $this->hasChild('inputSetRefs');
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
