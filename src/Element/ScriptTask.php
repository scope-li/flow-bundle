<?php

namespace Scopeli\FlowBundle\Element;

class ScriptTask extends Task
{
    public function getScript() : ?string
    {
        $child = $this->getChild('script');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return $child->nodeValue;
    }

    public function hasScript() : bool
    {
        return $this->hasChild('script');
    }

    public function getScriptFormat() : ?string
    {
        $value = $this->getAttribute('scriptFormat');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasScriptFormat() : bool
    {
        return $this->hasAttribute('scriptFormat');
    }

    public function getResultVariable() : ?string
    {
        $value = $this->getAttribute('resultVariable');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasResultVariable() : bool
    {
        return $this->hasAttribute('resultVariable');
    }
}
