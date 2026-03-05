<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class CorrelationPropertyBinding extends BaseElement
{
    public function getDataPath(): FormalExpression
    {
        $child = $this->getChild('dataPath');

        assert($child instanceof DOMElement);
        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasDataPath(): bool
    {
        return $this->hasChild('dataPath');
    }

    public function getCorrelationPropertyRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('correlationPropertyRef'));
    }

    public function hasCorrelationPropertyRef(): bool
    {
        return $this->hasAttribute('correlationPropertyRef');
    }
}
