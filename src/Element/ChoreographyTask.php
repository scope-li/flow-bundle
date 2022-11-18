<?php

namespace Scopeli\FlowBundle\Element;

class ChoreographyTask extends ChoreographyActivity
{
    /** @return ElementList<AbstractElement> */
    public function getMessageFlowRef() : ElementList
    {
        return new ElementList($this->getRefChilds('messageFlowRef'));
    }

    public function hasMessageFlowRef() : bool
    {
        return $this->hasChild('messageFlowRef');
    }
}
