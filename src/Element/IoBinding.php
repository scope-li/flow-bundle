<?php

namespace Scopeli\FlowBundle\Element;

class IoBinding extends BaseElement
{
    public function getOperationRef() : AbstractElement
    {
        $value = $this->getAttribute('operationRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasOperationRef() : bool
    {
        return $this->hasAttribute('operationRef');
    }

    public function getInputDataRef() : AbstractElement
    {
        $value = $this->getAttribute('inputDataRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasInputDataRef() : bool
    {
        return $this->hasAttribute('inputDataRef');
    }

    public function getOutputDataRef() : AbstractElement
    {
        $value = $this->getAttribute('outputDataRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasOutputDataRef() : bool
    {
        return $this->hasAttribute('outputDataRef');
    }
}
