<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class FormalExpression extends Expression
{
    public function getLanguage(): ?string
    {
        $value = $this->getAttribute('language');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasLanguage(): bool
    {
        return $this->hasAttribute('language');
    }

    public function getEvaluatesToTypeRef(): ?AbstractElement
    {
        $value = $this->getAttribute('evaluatesToTypeRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasEvaluatesToTypeRef(): bool
    {
        return $this->hasAttribute('evaluatesToTypeRef');
    }
}
