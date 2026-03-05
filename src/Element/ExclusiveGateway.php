<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ExclusiveGateway extends Gateway
{
    public function getDefault(): ?AbstractElement
    {
        $value = $this->getAttribute('default');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasDefault(): bool
    {
        return $this->hasAttribute('default');
    }
}
