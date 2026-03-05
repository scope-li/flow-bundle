<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class GlobalBusinessRuleTask extends GlobalTask
{
    public function getImplementation(): string
    {
        return $this->getAttribute('implementation') ?? '##unspecified';
    }

    public function hasImplementation(): bool
    {
        return $this->hasAttribute('implementation');
    }
}
