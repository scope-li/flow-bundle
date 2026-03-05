<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class CallActivity extends Activity
{
    public function getCalledElement(): ?AbstractElement
    {
        $value = $this->getAttribute('calledElement');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasCalledElement(): bool
    {
        return $this->hasAttribute('calledElement');
    }
}
