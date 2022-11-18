<?php

namespace Scopeli\FlowBundle\Element;

class LinkEventDefinition extends EventDefinition
{
    /** @return ElementList<AbstractElement> */
    public function getSource() : ElementList
    {
        return new ElementList($this->getRefChilds('source'));
    }

    public function hasSource() : bool
    {
        return $this->hasChild('source');
    }

    public function getTarget() : ?AbstractElement
    {
        $child = $this->getChild('target');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasTarget() : bool
    {
        return $this->hasChild('target');
    }

    public function getName() : string
    {
        $value = $this->getAttribute('name');

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }
}
