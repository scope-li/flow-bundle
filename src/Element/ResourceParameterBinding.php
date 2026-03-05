<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class ResourceParameterBinding extends BaseElement
{
    public function getFormalExpression(): FormalExpression
    {
        $child = $this->getChild('formalExpression');

        assert($child instanceof DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasFormalExpression(): bool
    {
        return $this->hasChild('formalExpression');
    }

    public function getParameterRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('parameterRef'));
    }

    public function hasParameterRef(): bool
    {
        return $this->hasAttribute('parameterRef');
    }
}
