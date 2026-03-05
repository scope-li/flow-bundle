<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ConversationAssociation extends BaseElement
{
    public function getInnerConversationNodeRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('innerConversationNodeRef'));
    }

    public function hasInnerConversationNodeRef(): bool
    {
        return $this->hasAttribute('innerConversationNodeRef');
    }

    public function getOuterConversationNodeRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('outerConversationNodeRef'));
    }

    public function hasOuterConversationNodeRef(): bool
    {
        return $this->hasAttribute('outerConversationNodeRef');
    }
}
