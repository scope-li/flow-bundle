<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class SequenceFlow extends FlowElement
{
    public function getConditionExpression(): ?Expression
    {
        $child = $this->getChild('conditionExpression');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasConditionExpression(): bool
    {
        return $this->hasChild('conditionExpression');
    }

    public function getSourceRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('sourceRef'));
    }

    public function hasSourceRef(): bool
    {
        return $this->hasAttribute('sourceRef');
    }

    public function getTargetRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('targetRef'));
    }

    public function hasTargetRef(): bool
    {
        return $this->hasAttribute('targetRef');
    }

    public function getIsImmediate(): ?bool
    {
        $value = $this->getAttribute('isImmediate');

        if (null === $value) {
            return null;
        }

        return 'true' === $value;
    }

    public function hasIsImmediate(): bool
    {
        return $this->hasAttribute('isImmediate');
    }
}
