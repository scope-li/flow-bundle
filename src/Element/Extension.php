<?php

namespace Scopeli\FlowBundle\Element;

class Extension extends AbstractElement
{
    /** @return ElementList<Documentation> */
    public function getDocumentation() : ElementList
    {
        /** @var ElementList<Documentation> $elements */
        $elements = new ElementList($this->getChilds('documentation'));

        return $elements;
    }

    public function hasDocumentation() : bool
    {
        return $this->hasChild('documentation');
    }

    public function getDefinition() : ?AbstractElement
    {
        $value = $this->getAttribute('definition');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasDefinition() : bool
    {
        return $this->hasAttribute('definition');
    }

    public function getMustUnderstand() : bool
    {
        $value = $this->getAttribute('mustUnderstand') ?? 'false';

        return 'true' === $value;
    }

    public function hasMustUnderstand() : bool
    {
        return $this->hasAttribute('mustUnderstand');
    }
}
