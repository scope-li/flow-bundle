<?php

namespace Scopeli\FlowBundle\Element;

class CategoryValue extends BaseElement
{
    public function getValue() : ?string
    {
        $value = $this->getAttribute('value');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasValue() : bool
    {
        return $this->hasAttribute('value');
    }
}
