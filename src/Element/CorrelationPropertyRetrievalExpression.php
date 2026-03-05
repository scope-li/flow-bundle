<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class CorrelationPropertyRetrievalExpression extends BaseElement
{
    public function getMessagePath(): FormalExpression
    {
        $child = $this->getChild('messagePath');

        assert($child instanceof DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasMessagePath(): bool
    {
        return $this->hasChild('messagePath');
    }

    public function getMessageRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('messageRef'));
    }

    public function hasMessageRef(): bool
    {
        return $this->hasAttribute('messageRef');
    }
}
