<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class DataStore extends RootElement
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

    public function getCapacity(): ?int
    {
        $value = $this->getAttribute('capacity');

        if (null === $value) {
            return null;
        }

        return (int) $value;
    }

    public function hasCapacity(): bool
    {
        return $this->hasAttribute('capacity');
    }

    public function getIsUnlimited(): bool
    {
        return 'true' === ($this->getAttribute('isUnlimited') ?? 'true');
    }

    public function hasIsUnlimited(): bool
    {
        return $this->hasAttribute('isUnlimited');
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
}
