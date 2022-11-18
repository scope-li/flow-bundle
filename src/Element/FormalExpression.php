<?php

namespace Scopeli\FlowBundle\Element;

class FormalExpression extends Expression
{
    public function getLanguage() : ?string
    {
        $value = $this->getAttribute('language');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasLanguage() : bool
    {
        return $this->hasAttribute('language');
    }

    public function getEvaluatesToTypeRef() : ?AbstractElement
    {
        $value = $this->getAttribute('evaluatesToTypeRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasEvaluatesToTypeRef() : bool
    {
        return $this->hasAttribute('evaluatesToTypeRef');
    }
}
