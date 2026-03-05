<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Documentation extends AbstractElement
{
    public function getTextFormat(): string
    {
        return $this->getAttribute('textFormat') ?? 'text/plain';
    }

    public function hasTextFormat(): bool
    {
        return $this->hasAttribute('textFormat');
    }
}
