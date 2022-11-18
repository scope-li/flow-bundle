<?php

namespace Scopeli\FlowBundle\Element;

class GlobalChoreographyTask extends Choreography
{
    public function getInitiatingParticipantRef() : ?AbstractElement
    {
        $value = $this->getAttribute('initiatingParticipantRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasInitiatingParticipantRef() : bool
    {
        return $this->hasAttribute('initiatingParticipantRef');
    }
}
