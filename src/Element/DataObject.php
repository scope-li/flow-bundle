<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class DataObject extends FlowElement
{
    public function getDataState(): ?DataState
    {
        $child = $this->getChild('dataState');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new DataState($child, $this->getBpmn());
    }

    public function hasDataState(): bool
    {
        return $this->hasChild('dataState');
    }

    public function getItemSubjectRef(): ?AbstractElement
    {
        $value = $this->getAttribute('itemSubjectRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasItemSubjectRef(): bool
    {
        return $this->hasAttribute('itemSubjectRef');
    }

    public function getIsCollection(): bool
    {
        return 'true' === ($this->getAttribute('isCollection') ?? 'false');
    }

    public function hasIsCollection(): bool
    {
        return $this->hasAttribute('isCollection');
    }
}
