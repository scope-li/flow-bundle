<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

class TextAnnotation extends Artifact
{
    public function getText(): ?string
    {
        $child = $this->getChild('text');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return $child->nodeValue;
    }

    public function hasText(): bool
    {
        return $this->hasChild('text');
    }

    public function getTextFormat(): string
    {
        return $this->getAttribute('textFormat') ?? 'text/plain';
    }

    public function hasTextFormat(): bool
    {
        return $this->hasAttribute('textFormat');
    }
}
