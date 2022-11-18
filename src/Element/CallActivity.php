<?php

namespace Scopeli\FlowBundle\Element;

class CallActivity extends Activity
{
    public function getCalledElement() : ?AbstractElement
    {
        $value = $this->getAttribute('calledElement');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCalledElement() : bool
    {
        return $this->hasAttribute('calledElement');
    }
}
