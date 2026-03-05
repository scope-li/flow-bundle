<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class IoBinding extends BaseElement
{
    public function getOperationRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('operationRef'));
    }

    public function hasOperationRef(): bool
    {
        return $this->hasAttribute('operationRef');
    }

    public function getInputDataRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('inputDataRef'));
    }

    public function hasInputDataRef(): bool
    {
        return $this->hasAttribute('inputDataRef');
    }

    public function getOutputDataRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('outputDataRef'));
    }

    public function hasOutputDataRef(): bool
    {
        return $this->hasAttribute('outputDataRef');
    }
}
