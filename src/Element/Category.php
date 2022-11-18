<?php

namespace Scopeli\FlowBundle\Element;

class Category extends RootElement
{
    /** @return ElementList<CategoryValue> */
    public function getCategoryValue() : ElementList
    {
        /** @var ElementList<CategoryValue> $elements */
        $elements = new ElementList($this->getChilds('categoryValue'));

        return $elements;
    }

    public function hasCategoryValue() : bool
    {
        return $this->hasChild('categoryValue');
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
