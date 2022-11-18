<?php

namespace Scopeli\FlowBundle\Element;

class SubConversation extends ConversationNode
{
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
}
