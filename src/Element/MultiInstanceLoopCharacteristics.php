<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class MultiInstanceLoopCharacteristics extends LoopCharacteristics
{
    public function getLoopCardinality(): ?Expression
    {
        $child = $this->getChild('loopCardinality');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasLoopCardinality(): bool
    {
        return $this->hasChild('loopCardinality');
    }

    public function getLoopDataInputRef(): ?AbstractElement
    {
        $child = $this->getChild('loopDataInputRef');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasLoopDataInputRef(): bool
    {
        return $this->hasChild('loopDataInputRef');
    }

    public function getLoopDataOutputRef(): ?AbstractElement
    {
        $child = $this->getChild('loopDataOutputRef');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasLoopDataOutputRef(): bool
    {
        return $this->hasChild('loopDataOutputRef');
    }

    public function getInputDataItem(): ?DataInput
    {
        $child = $this->getChild('inputDataItem');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new DataInput($child, $this->getBpmn());
    }

    public function hasInputDataItem(): bool
    {
        return $this->hasChild('inputDataItem');
    }

    public function getOutputDataItem(): ?DataOutput
    {
        $child = $this->getChild('outputDataItem');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new DataOutput($child, $this->getBpmn());
    }

    public function hasOutputDataItem(): bool
    {
        return $this->hasChild('outputDataItem');
    }

    /** @return ElementList<ComplexBehaviorDefinition> */
    public function getComplexBehaviorDefinition(): ElementList
    {
        /** @var ElementList<ComplexBehaviorDefinition> $elements */
        $elements = new ElementList($this->getChilds('complexBehaviorDefinition'));

        return $elements;
    }

    public function hasComplexBehaviorDefinition(): bool
    {
        return $this->hasChild('complexBehaviorDefinition');
    }

    public function getCompletionCondition(): ?Expression
    {
        $child = $this->getChild('completionCondition');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasCompletionCondition(): bool
    {
        return $this->hasChild('completionCondition');
    }

    public function getIsSequential(): bool
    {
        return 'true' === ($this->getAttribute('isSequential') ?? 'false');
    }

    public function hasIsSequential(): bool
    {
        return $this->hasAttribute('isSequential');
    }

    public function getBehavior(): string
    {
        return $this->getAttribute('behavior') ?? 'All';
    }

    public function hasBehavior(): bool
    {
        return $this->hasAttribute('behavior');
    }

    public function getOneBehaviorEventRef(): ?AbstractElement
    {
        $value = $this->getAttribute('oneBehaviorEventRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasOneBehaviorEventRef(): bool
    {
        return $this->hasAttribute('oneBehaviorEventRef');
    }

    public function getNoneBehaviorEventRef(): ?AbstractElement
    {
        $value = $this->getAttribute('noneBehaviorEventRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasNoneBehaviorEventRef(): bool
    {
        return $this->hasAttribute('noneBehaviorEventRef');
    }
}
