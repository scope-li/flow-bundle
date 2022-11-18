<?php

namespace Scopeli\FlowBundle\Element;

class ParticipantMultiplicity extends BaseElement
{
    public function getMinimum() : int
    {
        $value = $this->getAttribute('minimum') ?? '0';

        return (int) $value;
    }

    public function hasMinimum() : bool
    {
        return $this->hasAttribute('minimum');
    }

    public function getMaximum() : int
    {
        $value = $this->getAttribute('maximum') ?? '1';

        return (int) $value;
    }

    public function hasMaximum() : bool
    {
        return $this->hasAttribute('maximum');
    }
}
