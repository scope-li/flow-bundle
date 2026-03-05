<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Resource extends RootElement
{
    /** @return ElementList<ResourceParameter> */
    public function getResourceParameter(): ElementList
    {
        /** @var ElementList<ResourceParameter> $elements */
        $elements = new ElementList($this->getChilds('resourceParameter'));

        return $elements;
    }

    public function hasResourceParameter(): bool
    {
        return $this->hasChild('resourceParameter');
    }

    public function getName(): string
    {
        return (string) $this->getAttribute('name');
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }
}
