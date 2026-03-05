<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ServiceTask extends Task
{
    public function getImplementation(): string
    {
        return $this->getAttribute('implementation') ?? '##WebService';
    }

    public function hasImplementation(): bool
    {
        return $this->hasAttribute('implementation');
    }

    public function getOperationRef(): ?AbstractElement
    {
        $value = $this->getAttribute('operationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasOperationRef(): bool
    {
        return $this->hasAttribute('operationRef');
    }
}
