<?php

namespace Scopeli\FlowBundle\Element;

class CompensateEventDefinition extends EventDefinition
{
    public function getWaitForCompletion() : ?bool
    {
        $value = $this->getAttribute('waitForCompletion');

        if (null === $value) {
            return null;
        }

        return 'true' === $value;
    }

    public function hasWaitForCompletion() : bool
    {
        return $this->hasAttribute('waitForCompletion');
    }

    public function getActivityRef() : ?AbstractElement
    {
        $value = $this->getAttribute('activityRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasActivityRef() : bool
    {
        return $this->hasAttribute('activityRef');
    }
}
