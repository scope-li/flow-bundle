<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class CorrelationProperty extends RootElement
{
    /** @return ElementList<CorrelationPropertyRetrievalExpression> */
    public function getCorrelationPropertyRetrievalExpression(): ElementList
    {
        /** @var ElementList<CorrelationPropertyRetrievalExpression> $elements */
        $elements = new ElementList($this->getChilds('correlationPropertyRetrievalExpression'));

        return $elements;
    }

    public function hasCorrelationPropertyRetrievalExpression(): bool
    {
        return $this->hasChild('correlationPropertyRetrievalExpression');
    }

    public function getName(): ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }

    public function getType(): ?AbstractElement
    {
        $value = $this->getAttribute('type');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasType(): bool
    {
        return $this->hasAttribute('type');
    }
}
