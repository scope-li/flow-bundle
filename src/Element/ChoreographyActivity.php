<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

abstract class ChoreographyActivity extends FlowNode
{
    /** @return ElementList<AbstractElement> */
    public function getParticipantRef(): ElementList
    {
        return new ElementList($this->getRefChilds('participantRef'));
    }

    public function hasParticipantRef(): bool
    {
        return $this->hasChild('participantRef');
    }

    /** @return ElementList<CorrelationKey> */
    public function getCorrelationKey(): ElementList
    {
        /** @var ElementList<CorrelationKey> $elements */
        $elements = new ElementList($this->getChilds('correlationKey'));

        return $elements;
    }

    public function hasCorrelationKey(): bool
    {
        return $this->hasChild('correlationKey');
    }

    public function getInitiatingParticipantRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('initiatingParticipantRef'));
    }

    public function hasInitiatingParticipantRef(): bool
    {
        return $this->hasAttribute('initiatingParticipantRef');
    }

    public function getLoopType(): string
    {
        return $this->getAttribute('loopType') ?? 'None';
    }

    public function hasLoopType(): bool
    {
        return $this->hasAttribute('loopType');
    }
}
