<?php

namespace Scopeli\FlowBundle\Element;

class CallConversation extends ConversationNode
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

    public function getCalledCollaborationRef() : ?AbstractElement
    {
        $value = $this->getAttribute('calledCollaborationRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasCalledCollaborationRef() : bool
    {
        return $this->hasAttribute('calledCollaborationRef');
    }
}
