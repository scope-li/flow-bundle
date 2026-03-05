<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Extension extends AbstractElement
{
    /** @return ElementList<Documentation> */
    public function getDocumentation(): ElementList
    {
        /** @var ElementList<Documentation> $elements */
        $elements = new ElementList($this->getChilds('documentation'));

        return $elements;
    }

    public function hasDocumentation(): bool
    {
        return $this->hasChild('documentation');
    }

    public function getDefinition(): ?AbstractElement
    {
        $value = $this->getAttribute('definition');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasDefinition(): bool
    {
        return $this->hasAttribute('definition');
    }

    public function getMustUnderstand(): bool
    {
        return 'true' === ($this->getAttribute('mustUnderstand') ?? 'false');
    }

    public function hasMustUnderstand(): bool
    {
        return $this->hasAttribute('mustUnderstand');
    }
}
