<?php

namespace Scopeli\FlowBundle\Element;

class LaneSet extends BaseElement
{
    /** @return ElementList<Lane> */
    public function getLane() : ElementList
    {
        /** @var ElementList<Lane> $elements */
        $elements = new ElementList($this->getChilds('lane'));

        return $elements;
    }

    public function hasLane() : bool
    {
        return $this->hasChild('lane');
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
