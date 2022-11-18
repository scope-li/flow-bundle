<?php

namespace Scopeli\FlowBundle\Element;

class Lane extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getFlowNodeRef() : ElementList
    {
        return new ElementList($this->getRefChilds('flowNodeRef'));
    }

    public function hasFlowNodeRef() : bool
    {
        return $this->hasChild('flowNodeRef');
    }

    public function getChildLaneSet() : ?LaneSet
    {
        $child = $this->getChild('childLaneSet');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new LaneSet($child, $this->getBpmn());
    }

    public function hasChildLaneSet() : bool
    {
        return $this->hasChild('childLaneSet');
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

    public function getPartitionElementRef() : ?AbstractElement
    {
        $value = $this->getAttribute('partitionElementRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasPartitionElementRef() : bool
    {
        return $this->hasAttribute('partitionElementRef');
    }
}
