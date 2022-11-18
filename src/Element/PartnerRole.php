<?php

namespace Scopeli\FlowBundle\Element;

class PartnerRole extends RootElement
{
    /** @return ElementList<AbstractElement> */
    public function getParticipantRef() : ElementList
    {
        return new ElementList($this->getRefChilds('participantRef'));
    }

    public function hasParticipantRef() : bool
    {
        return $this->hasChild('participantRef');
    }

    public function getName() : ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }
}
