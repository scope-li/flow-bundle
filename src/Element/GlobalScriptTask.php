<?php

namespace Scopeli\FlowBundle\Element;

class GlobalScriptTask extends GlobalTask
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

    public function getScriptLanguage() : ?string
    {
        $value = $this->getAttribute('scriptLanguage');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasScriptLanguage() : bool
    {
        return $this->hasAttribute('scriptLanguage');
    }
}
