<?php

namespace Scopeli\FlowBundle\Element;

abstract class FlowNode extends FlowElement
{
    /** @return ElementList<AbstractElement> */
    public function getIncoming() : ElementList
    {
        return new ElementList($this->getRefChilds('incoming'));
    }

    public function hasIncoming() : bool
    {
        return $this->hasChild('incoming');
    }

    /** @return ElementList<AbstractElement> */
    public function getOutgoing() : ElementList
    {
        return new ElementList($this->getRefChilds('outgoing'));
    }

    public function hasOutgoing() : bool
    {
        return $this->hasChild('outgoing');
    }
}
