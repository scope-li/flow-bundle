<?php

namespace Scopeli\FlowBundle\Element;

class Signal extends RootElement
{
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

    public function getStructureRef() : ?AbstractElement
    {
        $value = $this->getAttribute('structureRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasStructureRef() : bool
    {
        return $this->hasAttribute('structureRef');
    }
}
