<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class StandardLoopCharacteristics extends LoopCharacteristics
{
    public function getLoopCondition(): ?Expression
    {
        $child = $this->getChild('loopCondition');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasLoopCondition(): bool
    {
        return $this->hasChild('loopCondition');
    }

    public function getTestBefore(): bool
    {
        return 'true' === ($this->getAttribute('testBefore') ?? 'false');
    }

    public function hasTestBefore(): bool
    {
        return $this->hasAttribute('testBefore');
    }

    public function getLoopMaximum(): ?int
    {
        $value = $this->getAttribute('loopMaximum');

        if (null === $value) {
            return null;
        }

        return (int) $value;
    }

    public function hasLoopMaximum(): bool
    {
        return $this->hasAttribute('loopMaximum');
    }
}
