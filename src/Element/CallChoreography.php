<?php

namespace Scopeli\FlowBundle\Element;

class CallChoreography extends ChoreographyActivity
{
    /** @return ElementList<ParticipantAssociation> */
    public function getParticipantAssociation() : ElementList
    {
        /** @var ElementList<ParticipantAssociation> $elements */
        $elements = new ElementList($this->getChilds('participantAssociation'));

        return $elements;
    }

    public function hasParticipantAssociation() : bool
    {
        return $this->hasChild('participantAssociation');
    }

    public function getCalledChoreographyRef() : ?AbstractElement
    {
        $value = $this->getAttribute('calledChoreographyRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCalledChoreographyRef() : bool
    {
        return $this->hasAttribute('calledChoreographyRef');
    }
}
