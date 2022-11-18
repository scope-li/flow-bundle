<?php

namespace Scopeli\FlowBundle\Element;

abstract class ThrowEvent extends Event
{
    /** @return ElementList<DataInput> */
    public function getDataInput() : ElementList
    {
        /** @var ElementList<DataInput> $elements */
        $elements = new ElementList($this->getChilds('dataInput'));

        return $elements;
    }

    public function hasDataInput() : bool
    {
        return $this->hasChild('dataInput');
    }

    /** @return ElementList<DataInputAssociation> */
    public function getDataInputAssociation() : ElementList
    {
        /** @var ElementList<DataInputAssociation> $elements */
        $elements = new ElementList($this->getChilds('dataInputAssociation'));

        return $elements;
    }

    public function hasDataInputAssociation() : bool
    {
        return $this->hasChild('dataInputAssociation');
    }

    public function getInputSet() : ?InputSet
    {
        $child = $this->getChild('inputSet');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new InputSet($child, $this->getBpmn());
    }

    public function hasInputSet() : bool
    {
        return $this->hasChild('inputSet');
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
}
