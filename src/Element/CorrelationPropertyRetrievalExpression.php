<?php

namespace Scopeli\FlowBundle\Element;

class CorrelationPropertyRetrievalExpression extends BaseElement
{
    public function getMessagePath() : FormalExpression
    {
        $child = $this->getChild('messagePath');

        assert($child instanceof \DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasMessagePath() : bool
    {
        return $this->hasChild('messagePath');
    }

    public function getMessageRef() : AbstractElement
    {
        $value = $this->getAttribute('messageRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasMessageRef() : bool
    {
        return $this->hasAttribute('messageRef');
    }
}
