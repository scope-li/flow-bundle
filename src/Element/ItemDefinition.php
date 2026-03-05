<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ItemDefinition extends RootElement
{
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

    public function getIsCollection(): bool
    {
        return 'true' === ($this->getAttribute('isCollection') ?? 'false');
    }

    public function hasIsCollection(): bool
    {
        return $this->hasAttribute('isCollection');
    }

    public function getItemKind(): string
    {
        return $this->getAttribute('itemKind') ?? 'Information';
    }

    public function hasItemKind(): bool
    {
        return $this->hasAttribute('itemKind');
    }
}
