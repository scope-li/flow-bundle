<?php

namespace Scopeli\FlowBundle\Element;

class Group extends Artifact
{
    public function getCategoryValueRef() : ?AbstractElement
    {
        $value = $this->getAttribute('categoryValueRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCategoryValueRef() : bool
    {
        return $this->hasAttribute('categoryValueRef');
    }
}
