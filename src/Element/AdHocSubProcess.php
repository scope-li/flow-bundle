<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class AdHocSubProcess extends SubProcess
{
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

    public function getCancelRemainingInstances(): bool
    {
        return 'true' === ($this->getAttribute('cancelRemainingInstances') ?? 'true');
    }

    public function hasCancelRemainingInstances(): bool
    {
        return $this->hasAttribute('cancelRemainingInstances');
    }

    public function getOrdering(): ?string
    {
        $value = $this->getAttribute('ordering');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasOrdering(): bool
    {
        return $this->hasAttribute('ordering');
    }
}
