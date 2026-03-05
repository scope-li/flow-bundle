<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ParticipantMultiplicity extends BaseElement
{
    public function getMinimum(): int
    {
        return (int) ($this->getAttribute('minimum') ?? '0');
    }

    public function hasMinimum(): bool
    {
        return $this->hasAttribute('minimum');
    }

    public function getMaximum(): int
    {
        return (int) ($this->getAttribute('maximum') ?? '1');
    }

    public function hasMaximum(): bool
    {
        return $this->hasAttribute('maximum');
    }
}
