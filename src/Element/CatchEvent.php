<?php

namespace Scopeli\FlowBundle\Element;

abstract class CatchEvent extends Event
{
    /** @return ElementList<DataOutput> */
    public function getDataOutput() : ElementList
    {
        /** @var ElementList<DataOutput> $elements */
        $elements = new ElementList($this->getChilds('dataOutput'));

        return $elements;
    }

    public function hasDataOutput() : bool
    {
        return $this->hasChild('dataOutput');
    }

    /** @return ElementList<DataOutputAssociation> */
    public function getDataOutputAssociation() : ElementList
    {
        /** @var ElementList<DataOutputAssociation> $elements */
        $elements = new ElementList($this->getChilds('dataOutputAssociation'));

        return $elements;
    }

    public function hasDataOutputAssociation() : bool
    {
        return $this->hasChild('dataOutputAssociation');
    }

    public function getOutputSet() : ?OutputSet
    {
        $child = $this->getChild('outputSet');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new OutputSet($child, $this->getBpmn());
    }

    public function hasOutputSet() : bool
    {
        return $this->hasChild('outputSet');
    }

    /** @return ElementList<CancelEventDefinition> */
    public function getCancelEventDefinition() : ElementList
    {
        /** @var ElementList<CancelEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('cancelEventDefinition'));

        return $elements;
    }

    public function hasCancelEventDefinition() : bool
    {
        return $this->hasChild('cancelEventDefinition');
    }

    /** @return ElementList<CompensateEventDefinition> */
    public function getCompensateEventDefinition() : ElementList
    {
        /** @var ElementList<CompensateEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('compensateEventDefinition'));

        return $elements;
    }

    public function hasCompensateEventDefinition() : bool
    {
        return $this->hasChild('compensateEventDefinition');
    }

    /** @return ElementList<ConditionalEventDefinition> */
    public function getConditionalEventDefinition() : ElementList
    {
        /** @var ElementList<ConditionalEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('conditionalEventDefinition'));

        return $elements;
    }

    public function hasConditionalEventDefinition() : bool
    {
        return $this->hasChild('conditionalEventDefinition');
    }

    /** @return ElementList<ErrorEventDefinition> */
    public function getErrorEventDefinition() : ElementList
    {
        /** @var ElementList<ErrorEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('errorEventDefinition'));

        return $elements;
    }

    public function hasErrorEventDefinition() : bool
    {
        return $this->hasChild('errorEventDefinition');
    }

    /** @return ElementList<EscalationEventDefinition> */
    public function getEscalationEventDefinition() : ElementList
    {
        /** @var ElementList<EscalationEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('escalationEventDefinition'));

        return $elements;
    }

    public function hasEscalationEventDefinition() : bool
    {
        return $this->hasChild('escalationEventDefinition');
    }

    /** @return ElementList<LinkEventDefinition> */
    public function getLinkEventDefinition() : ElementList
    {
        /** @var ElementList<LinkEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('linkEventDefinition'));

        return $elements;
    }

    public function hasLinkEventDefinition() : bool
    {
        return $this->hasChild('linkEventDefinition');
    }

    /** @return ElementList<MessageEventDefinition> */
    public function getMessageEventDefinition() : ElementList
    {
        /** @var ElementList<MessageEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('messageEventDefinition'));

        return $elements;
    }

    public function hasMessageEventDefinition() : bool
    {
        return $this->hasChild('messageEventDefinition');
    }

    /** @return ElementList<SignalEventDefinition> */
    public function getSignalEventDefinition() : ElementList
    {
        /** @var ElementList<SignalEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('signalEventDefinition'));

        return $elements;
    }

    public function hasSignalEventDefinition() : bool
    {
        return $this->hasChild('signalEventDefinition');
    }

    /** @return ElementList<TerminateEventDefinition> */
    public function getTerminateEventDefinition() : ElementList
    {
        /** @var ElementList<TerminateEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('terminateEventDefinition'));

        return $elements;
    }

    public function hasTerminateEventDefinition() : bool
    {
        return $this->hasChild('terminateEventDefinition');
    }

    /** @return ElementList<TimerEventDefinition> */
    public function getTimerEventDefinition() : ElementList
    {
        /** @var ElementList<TimerEventDefinition> $elements */
        $elements = new ElementList($this->getChilds('timerEventDefinition'));

        return $elements;
    }

    public function hasTimerEventDefinition() : bool
    {
        return $this->hasChild('timerEventDefinition');
    }

    /** @return ElementList<AbstractElement> */
    public function getEventDefinitionRef() : ElementList
    {
        return new ElementList($this->getRefChilds('eventDefinitionRef'));
    }

    public function hasEventDefinitionRef() : bool
    {
        return $this->hasChild('eventDefinitionRef');
    }

    public function getParallelMultiple() : bool
    {
        $value = $this->getAttribute('parallelMultiple') ?? 'false';

        return 'true' === $value;
    }

    public function hasParallelMultiple() : bool
    {
        return $this->hasAttribute('parallelMultiple');
    }
}
