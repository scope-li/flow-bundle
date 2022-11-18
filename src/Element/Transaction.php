<?php

namespace Scopeli\FlowBundle\Element;

class Transaction extends SubProcess
{
    public function getMethod() : string
    {
        $value = $this->getAttribute('method') ?? '##Compensate';

        return (string) $value;
    }

    public function hasMethod() : bool
    {
        return $this->hasAttribute('method');
    }
}
