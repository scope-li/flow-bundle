<?php

namespace Scopeli\FlowBundle\Element;

class Assignment extends BaseElement
{
    public function getFrom() : Expression
    {
        $child = $this->getChild('from');

        assert($child instanceof \DOMElement);
        return new Expression($child, $this->getBpmn());
    }

    public function hasFrom() : bool
    {
        return $this->hasChild('from');
    }

    public function getTo() : Expression
    {
        $child = $this->getChild('to');

        assert($child instanceof \DOMElement);
        return new Expression($child, $this->getBpmn());
    }

    public function hasTo() : bool
    {
        return $this->hasChild('to');
    }
}
