<?php

namespace Scopeli\FlowBundle\Element;

abstract class ChoreographyActivity extends FlowNode
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

    public function getInitiatingParticipantRef() : AbstractElement
    {
        $value = $this->getAttribute('initiatingParticipantRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasInitiatingParticipantRef() : bool
    {
        return $this->hasAttribute('initiatingParticipantRef');
    }

    public function getLoopType() : string
    {
        $value = $this->getAttribute('loopType') ?? 'None';

        return (string) $value;
    }

    public function hasLoopType() : bool
    {
        return $this->hasAttribute('loopType');
    }
}
