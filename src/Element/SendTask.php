<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class SendTask extends Task
{
    public function getImplementation(): string
    {
        return $this->getAttribute('implementation') ?? '##WebService';
    }

    public function hasImplementation(): bool
    {
        return $this->hasAttribute('implementation');
    }

    public function getMessageRef(): ?AbstractElement
    {
        $value = $this->getAttribute('messageRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasMessageRef(): bool
    {
        return $this->hasAttribute('messageRef');
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
