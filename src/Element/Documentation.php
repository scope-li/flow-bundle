<?php

namespace Scopeli\FlowBundle\Element;

class Documentation extends AbstractElement
{
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
