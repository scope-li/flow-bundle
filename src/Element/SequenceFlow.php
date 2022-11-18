<?php

namespace Scopeli\FlowBundle\Element;

class SequenceFlow extends FlowElement
{
    public function getConditionExpression() : ?Expression
    {
        $child = $this->getChild('conditionExpression');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasConditionExpression() : bool
    {
        return $this->hasChild('conditionExpression');
    }

    public function getSourceRef() : AbstractElement
    {
        $value = $this->getAttribute('sourceRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasSourceRef() : bool
    {
        return $this->hasAttribute('sourceRef');
    }

    public function getTargetRef() : AbstractElement
    {
        $value = $this->getAttribute('targetRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasTargetRef() : bool
    {
        return $this->hasAttribute('targetRef');
    }

    public function getIsImmediate() : ?bool
    {
        $value = $this->getAttribute('isImmediate');

        if (null === $value) {
            return null;
        }

        return 'true' === $value;
    }

    public function hasIsImmediate() : bool
    {
        return $this->hasAttribute('isImmediate');
    }
}
