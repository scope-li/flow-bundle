<?php

namespace Scopeli\FlowBundle\Element;

class ItemDefinition extends RootElement
{
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

    public function getIsCollection() : bool
    {
        $value = $this->getAttribute('isCollection') ?? 'false';

        return 'true' === $value;
    }

    public function hasIsCollection() : bool
    {
        return $this->hasAttribute('isCollection');
    }

    public function getItemKind() : string
    {
        $value = $this->getAttribute('itemKind') ?? 'Information';

        return (string) $value;
    }

    public function hasItemKind() : bool
    {
        return $this->hasAttribute('itemKind');
    }
}
