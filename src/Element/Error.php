<?php

namespace Scopeli\FlowBundle\Element;

class Error extends RootElement
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

    public function getErrorCode() : ?string
    {
        $value = $this->getAttribute('errorCode');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasErrorCode() : bool
    {
        return $this->hasAttribute('errorCode');
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
