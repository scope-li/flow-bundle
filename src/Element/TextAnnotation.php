<?php

namespace Scopeli\FlowBundle\Element;

class TextAnnotation extends Artifact
{
    public function getText() : ?string
    {
        $child = $this->getChild('text');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return $child->nodeValue;
    }

    public function hasText() : bool
    {
        return $this->hasChild('text');
    }

    public function getTextFormat() : string
    {
        $value = $this->getAttribute('textFormat') ?? 'text/plain';

        return (string) $value;
    }

    public function hasTextFormat() : bool
    {
        return $this->hasAttribute('textFormat');
    }
}
