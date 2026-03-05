<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Transaction extends SubProcess
{
    public function getMethod(): string
    {
        return $this->getAttribute('method') ?? '##Compensate';
    }

    public function hasMethod(): bool
    {
        return $this->hasAttribute('method');
    }
}
