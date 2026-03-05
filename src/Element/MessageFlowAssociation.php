<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class MessageFlowAssociation extends BaseElement
{
    public function getInnerMessageFlowRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('innerMessageFlowRef'));
    }

    public function hasInnerMessageFlowRef(): bool
    {
        return $this->hasAttribute('innerMessageFlowRef');
    }

    public function getOuterMessageFlowRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('outerMessageFlowRef'));
    }

    public function hasOuterMessageFlowRef(): bool
    {
        return $this->hasAttribute('outerMessageFlowRef');
    }
}
