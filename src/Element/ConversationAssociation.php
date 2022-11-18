<?php

namespace Scopeli\FlowBundle\Element;

class ConversationAssociation extends BaseElement
{
    public function getInnerConversationNodeRef() : AbstractElement
    {
        $value = $this->getAttribute('innerConversationNodeRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasInnerConversationNodeRef() : bool
    {
        return $this->hasAttribute('innerConversationNodeRef');
    }

    public function getOuterConversationNodeRef() : AbstractElement
    {
        $value = $this->getAttribute('outerConversationNodeRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasOuterConversationNodeRef() : bool
    {
        return $this->hasAttribute('outerConversationNodeRef');
    }
}
