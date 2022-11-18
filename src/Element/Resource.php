<?php

namespace Scopeli\FlowBundle\Element;

class Resource extends RootElement
{
    /** @return ElementList<ResourceParameter> */
    public function getResourceParameter() : ElementList
    {
        /** @var ElementList<ResourceParameter> $elements */
        $elements = new ElementList($this->getChilds('resourceParameter'));

        return $elements;
    }

    public function hasResourceParameter() : bool
    {
        return $this->hasChild('resourceParameter');
    }

    public function getName() : string
    {
        $value = $this->getAttribute('name');

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }
}
