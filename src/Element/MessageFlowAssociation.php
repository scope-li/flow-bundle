<?php

namespace Scopeli\FlowBundle\Element;

class MessageFlowAssociation extends BaseElement
{
    public function getInnerMessageFlowRef() : AbstractElement
    {
        $value = $this->getAttribute('innerMessageFlowRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasInnerMessageFlowRef() : bool
    {
        return $this->hasAttribute('innerMessageFlowRef');
    }

    public function getOuterMessageFlowRef() : AbstractElement
    {
        $value = $this->getAttribute('outerMessageFlowRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasOuterMessageFlowRef() : bool
    {
        return $this->hasAttribute('outerMessageFlowRef');
    }
}
