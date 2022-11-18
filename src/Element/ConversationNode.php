<?php

namespace Scopeli\FlowBundle\Element;

abstract class ConversationNode extends BaseElement
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

    /** @return ElementList<AbstractElement> */
    public function getMessageFlowRef() : ElementList
    {
        return new ElementList($this->getRefChilds('messageFlowRef'));
    }

    public function hasMessageFlowRef() : bool
    {
        return $this->hasChild('messageFlowRef');
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
