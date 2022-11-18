<?php

namespace Scopeli\FlowBundle\Element;

class ParticipantAssociation extends BaseElement
{
    public function getInnerParticipantRef() : AbstractElement
    {
        $child = $this->getChild('innerParticipantRef');

        assert($child instanceof \DOMElement);
        return self::createElement($child, $this->getBpmn());
    }

    public function hasInnerParticipantRef() : bool
    {
        return $this->hasChild('innerParticipantRef');
    }

    public function getOuterParticipantRef() : AbstractElement
    {
        $child = $this->getChild('outerParticipantRef');

        assert($child instanceof \DOMElement);
        return self::createElement($child, $this->getBpmn());
    }

    public function hasOuterParticipantRef() : bool
    {
        return $this->hasChild('outerParticipantRef');
    }
}
