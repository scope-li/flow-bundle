<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class MessageEventDefinition extends EventDefinition
{
    public function getOperationRef(): ?AbstractElement
    {
        $child = $this->getChild('operationRef');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasOperationRef(): bool
    {
        return $this->hasChild('operationRef');
    }

    public function getMessageRef(): ?AbstractElement
    {
        $value = $this->getAttribute('messageRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasMessageRef(): bool
    {
        return $this->hasAttribute('messageRef');
    }
}
