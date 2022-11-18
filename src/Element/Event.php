<?php

namespace Scopeli\FlowBundle\Element;

abstract class Event extends FlowNode
{
    /** @return ElementList<Property> */
    public function getProperty() : ElementList
    {
        /** @var ElementList<Property> $elements */
        $elements = new ElementList($this->getChilds('property'));

        return $elements;
    }

    public function hasProperty() : bool
    {
        return $this->hasChild('property');
    }
}
