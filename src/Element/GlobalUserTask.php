<?php

namespace Scopeli\FlowBundle\Element;

class GlobalUserTask extends GlobalTask
{
    /** @return ElementList<Rendering> */
    public function getRendering() : ElementList
    {
        /** @var ElementList<Rendering> $elements */
        $elements = new ElementList($this->getChilds('rendering'));

        return $elements;
    }

    public function hasRendering() : bool
    {
        return $this->hasChild('rendering');
    }

    public function getImplementation() : string
    {
        $value = $this->getAttribute('implementation') ?? '##unspecified';

        return (string) $value;
    }

    public function hasImplementation() : bool
    {
        return $this->hasAttribute('implementation');
    }
}
