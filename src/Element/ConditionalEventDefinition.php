<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class ConditionalEventDefinition extends EventDefinition
{
    public function getCondition(): ?Expression
    {
        $child = $this->getChild('condition');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasCondition(): bool
    {
        return $this->hasChild('condition');
    }
}
