<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Escalation extends RootElement
{
    public function getName(): ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }

    public function getEscalationCode(): ?string
    {
        $value = $this->getAttribute('escalationCode');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasEscalationCode(): bool
    {
        return $this->hasAttribute('escalationCode');
    }

    public function getStructureRef(): ?AbstractElement
    {
        $value = $this->getAttribute('structureRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasStructureRef(): bool
    {
        return $this->hasAttribute('structureRef');
    }
}
