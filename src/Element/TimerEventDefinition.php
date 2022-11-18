<?php

namespace Scopeli\FlowBundle\Element;

class TimerEventDefinition extends EventDefinition
{
    public function getTimeDate() : ?Expression
    {
        $child = $this->getChild('timeDate');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasTimeDate() : bool
    {
        return $this->hasChild('timeDate');
    }

    public function getTimeDuration() : ?Expression
    {
        $child = $this->getChild('timeDuration');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasTimeDuration() : bool
    {
        return $this->hasChild('timeDuration');
    }

    public function getTimeCycle() : ?Expression
    {
        $child = $this->getChild('timeCycle');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Expression($child, $this->getBpmn());
    }

    public function hasTimeCycle() : bool
    {
        return $this->hasChild('timeCycle');
    }
}
