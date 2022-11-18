<?php

namespace Scopeli\FlowBundle\Element;

class Relationship extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getSource() : ElementList
    {
        return new ElementList($this->getRefChilds('source'));
    }

    public function hasSource() : bool
    {
        return $this->hasChild('source');
    }

    /** @return ElementList<AbstractElement> */
    public function getTarget() : ElementList
    {
        return new ElementList($this->getRefChilds('target'));
    }

    public function hasTarget() : bool
    {
        return $this->hasChild('target');
    }

    public function getType() : string
    {
        $value = $this->getAttribute('type');

        return (string) $value;
    }

    public function hasType() : bool
    {
        return $this->hasAttribute('type');
    }

    public function getDirection() : ?string
    {
        $value = $this->getAttribute('direction');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasDirection() : bool
    {
        return $this->hasAttribute('direction');
    }
}
