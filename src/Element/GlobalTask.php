<?php

namespace Scopeli\FlowBundle\Element;

class GlobalTask extends CallableElement
{
    /** @return ElementList<Performer> */
    public function getPerformer() : ElementList
    {
        /** @var ElementList<Performer> $elements */
        $elements = new ElementList($this->getChilds('performer'));

        return $elements;
    }

    public function hasPerformer() : bool
    {
        return $this->hasChild('performer');
    }
}
