<?php

namespace Scopeli\FlowBundle\Element;

class Collaboration extends RootElement
{
    /** @return ElementList<Participant> */
    public function getParticipant() : ElementList
    {
        /** @var ElementList<Participant> $elements */
        $elements = new ElementList($this->getChilds('participant'));

        return $elements;
    }

    public function hasParticipant() : bool
    {
        return $this->hasChild('participant');
    }

    /** @return ElementList<MessageFlow> */
    public function getMessageFlow() : ElementList
    {
        /** @var ElementList<MessageFlow> $elements */
        $elements = new ElementList($this->getChilds('messageFlow'));

        return $elements;
    }

    public function hasMessageFlow() : bool
    {
        return $this->hasChild('messageFlow');
    }

    /** @return ElementList<Association> */
    public function getAssociation() : ElementList
    {
        /** @var ElementList<Association> $elements */
        $elements = new ElementList($this->getChilds('association'));

        return $elements;
    }

    public function hasAssociation() : bool
    {
        return $this->hasChild('association');
    }

    /** @return ElementList<Group> */
    public function getGroup() : ElementList
    {
        /** @var ElementList<Group> $elements */
        $elements = new ElementList($this->getChilds('group'));

        return $elements;
    }

    public function hasGroup() : bool
    {
        return $this->hasChild('group');
    }

    /** @return ElementList<TextAnnotation> */
    public function getTextAnnotation() : ElementList
    {
        /** @var ElementList<TextAnnotation> $elements */
        $elements = new ElementList($this->getChilds('textAnnotation'));

        return $elements;
    }

    public function hasTextAnnotation() : bool
    {
        return $this->hasChild('textAnnotation');
    }

    /** @return ElementList<CallConversation> */
    public function getCallConversation() : ElementList
    {
        /** @var ElementList<CallConversation> $elements */
        $elements = new ElementList($this->getChilds('callConversation'));

        return $elements;
    }

    public function hasCallConversation() : bool
    {
        return $this->hasChild('callConversation');
    }

    /** @return ElementList<Conversation> */
    public function getConversation() : ElementList
    {
        /** @var ElementList<Conversation> $elements */
        $elements = new ElementList($this->getChilds('conversation'));

        return $elements;
    }

    public function hasConversation() : bool
    {
        return $this->hasChild('conversation');
    }

    /** @return ElementList<SubConversation> */
    public function getSubConversation() : ElementList
    {
        /** @var ElementList<SubConversation> $elements */
        $elements = new ElementList($this->getChilds('subConversation'));

        return $elements;
    }

    public function hasSubConversation() : bool
    {
        return $this->hasChild('subConversation');
    }

    /** @return ElementList<ConversationAssociation> */
    public function getConversationAssociation() : ElementList
    {
        /** @var ElementList<ConversationAssociation> $elements */
        $elements = new ElementList($this->getChilds('conversationAssociation'));

        return $elements;
    }

    public function hasConversationAssociation() : bool
    {
        return $this->hasChild('conversationAssociation');
    }

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

    /** @return ElementList<MessageFlowAssociation> */
    public function getMessageFlowAssociation() : ElementList
    {
        /** @var ElementList<MessageFlowAssociation> $elements */
        $elements = new ElementList($this->getChilds('messageFlowAssociation'));

        return $elements;
    }

    public function hasMessageFlowAssociation() : bool
    {
        return $this->hasChild('messageFlowAssociation');
    }

    /** @return ElementList<CorrelationKey> */
    public function getCorrelationKey() : ElementList
    {
        /** @var ElementList<CorrelationKey> $elements */
        $elements = new ElementList($this->getChilds('correlationKey'));

        return $elements;
    }

    public function hasCorrelationKey() : bool
    {
        return $this->hasChild('correlationKey');
    }

    /** @return ElementList<AbstractElement> */
    public function getChoreographyRef() : ElementList
    {
        return new ElementList($this->getRefChilds('choreographyRef'));
    }

    public function hasChoreographyRef() : bool
    {
        return $this->hasChild('choreographyRef');
    }

    /** @return ElementList<ConversationLink> */
    public function getConversationLink() : ElementList
    {
        /** @var ElementList<ConversationLink> $elements */
        $elements = new ElementList($this->getChilds('conversationLink'));

        return $elements;
    }

    public function hasConversationLink() : bool
    {
        return $this->hasChild('conversationLink');
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

    public function getIsClosed() : bool
    {
        $value = $this->getAttribute('isClosed') ?? 'false';

        return 'true' === $value;
    }

    public function hasIsClosed() : bool
    {
        return $this->hasAttribute('isClosed');
    }
}
