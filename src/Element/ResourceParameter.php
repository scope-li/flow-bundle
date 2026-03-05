<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ResourceParameter extends BaseElement
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

    public function getType(): ?AbstractElement
    {
        $value = $this->getAttribute('type');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasType(): bool
    {
        return $this->hasAttribute('type');
    }

    public function getIsRequired(): ?bool
    {
        $value = $this->getAttribute('isRequired');

        if (null === $value) {
            return null;
        }

        return 'true' === $value;
    }

    public function hasIsRequired(): bool
    {
        return $this->hasAttribute('isRequired');
    }
}
