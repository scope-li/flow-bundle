<?php

namespace Scopeli\FlowBundle\Element;

class SubChoreography extends ChoreographyActivity
{
    /** @return ElementList<AdHocSubProcess> */
    public function getAdHocSubProcess() : ElementList
    {
        /** @var ElementList<AdHocSubProcess> $elements */
        $elements = new ElementList($this->getChilds('adHocSubProcess'));

        return $elements;
    }

    public function hasAdHocSubProcess() : bool
    {
        return $this->hasChild('adHocSubProcess');
    }

    /** @return ElementList<BoundaryEvent> */
    public function getBoundaryEvent() : ElementList
    {
        /** @var ElementList<BoundaryEvent> $elements */
        $elements = new ElementList($this->getChilds('boundaryEvent'));

        return $elements;
    }

    public function hasBoundaryEvent() : bool
    {
        return $this->hasChild('boundaryEvent');
    }

    /** @return ElementList<BusinessRuleTask> */
    public function getBusinessRuleTask() : ElementList
    {
        /** @var ElementList<BusinessRuleTask> $elements */
        $elements = new ElementList($this->getChilds('businessRuleTask'));

        return $elements;
    }

    public function hasBusinessRuleTask() : bool
    {
        return $this->hasChild('businessRuleTask');
    }

    /** @return ElementList<CallActivity> */
    public function getCallActivity() : ElementList
    {
        /** @var ElementList<CallActivity> $elements */
        $elements = new ElementList($this->getChilds('callActivity'));

        return $elements;
    }

    public function hasCallActivity() : bool
    {
        return $this->hasChild('callActivity');
    }

    /** @return ElementList<CallChoreography> */
    public function getCallChoreography() : ElementList
    {
        /** @var ElementList<CallChoreography> $elements */
        $elements = new ElementList($this->getChilds('callChoreography'));

        return $elements;
    }

    public function hasCallChoreography() : bool
    {
        return $this->hasChild('callChoreography');
    }

    /** @return ElementList<ChoreographyTask> */
    public function getChoreographyTask() : ElementList
    {
        /** @var ElementList<ChoreographyTask> $elements */
        $elements = new ElementList($this->getChilds('choreographyTask'));

        return $elements;
    }

    public function hasChoreographyTask() : bool
    {
        return $this->hasChild('choreographyTask');
    }

    /** @return ElementList<ComplexGateway> */
    public function getComplexGateway() : ElementList
    {
        /** @var ElementList<ComplexGateway> $elements */
        $elements = new ElementList($this->getChilds('complexGateway'));

        return $elements;
    }

    public function hasComplexGateway() : bool
    {
        return $this->hasChild('complexGateway');
    }

    /** @return ElementList<DataObject> */
    public function getDataObject() : ElementList
    {
        /** @var ElementList<DataObject> $elements */
        $elements = new ElementList($this->getChilds('dataObject'));

        return $elements;
    }

    public function hasDataObject() : bool
    {
        return $this->hasChild('dataObject');
    }

    /** @return ElementList<DataObjectReference> */
    public function getDataObjectReference() : ElementList
    {
        /** @var ElementList<DataObjectReference> $elements */
        $elements = new ElementList($this->getChilds('dataObjectReference'));

        return $elements;
    }

    public function hasDataObjectReference() : bool
    {
        return $this->hasChild('dataObjectReference');
    }

    /** @return ElementList<DataStoreReference> */
    public function getDataStoreReference() : ElementList
    {
        /** @var ElementList<DataStoreReference> $elements */
        $elements = new ElementList($this->getChilds('dataStoreReference'));

        return $elements;
    }

    public function hasDataStoreReference() : bool
    {
        return $this->hasChild('dataStoreReference');
    }

    /** @return ElementList<EndEvent> */
    public function getEndEvent() : ElementList
    {
        /** @var ElementList<EndEvent> $elements */
        $elements = new ElementList($this->getChilds('endEvent'));

        return $elements;
    }

    public function hasEndEvent() : bool
    {
        return $this->hasChild('endEvent');
    }

    /** @return ElementList<Event> */
    public function getEvent() : ElementList
    {
        /** @var ElementList<Event> $elements */
        $elements = new ElementList($this->getChilds('event'));

        return $elements;
    }

    public function hasEvent() : bool
    {
        return $this->hasChild('event');
    }

    /** @return ElementList<EventBasedGateway> */
    public function getEventBasedGateway() : ElementList
    {
        /** @var ElementList<EventBasedGateway> $elements */
        $elements = new ElementList($this->getChilds('eventBasedGateway'));

        return $elements;
    }

    public function hasEventBasedGateway() : bool
    {
        return $this->hasChild('eventBasedGateway');
    }

    /** @return ElementList<ExclusiveGateway> */
    public function getExclusiveGateway() : ElementList
    {
        /** @var ElementList<ExclusiveGateway> $elements */
        $elements = new ElementList($this->getChilds('exclusiveGateway'));

        return $elements;
    }

    public function hasExclusiveGateway() : bool
    {
        return $this->hasChild('exclusiveGateway');
    }

    /** @return ElementList<ImplicitThrowEvent> */
    public function getImplicitThrowEvent() : ElementList
    {
        /** @var ElementList<ImplicitThrowEvent> $elements */
        $elements = new ElementList($this->getChilds('implicitThrowEvent'));

        return $elements;
    }

    public function hasImplicitThrowEvent() : bool
    {
        return $this->hasChild('implicitThrowEvent');
    }

    /** @return ElementList<InclusiveGateway> */
    public function getInclusiveGateway() : ElementList
    {
        /** @var ElementList<InclusiveGateway> $elements */
        $elements = new ElementList($this->getChilds('inclusiveGateway'));

        return $elements;
    }

    public function hasInclusiveGateway() : bool
    {
        return $this->hasChild('inclusiveGateway');
    }

    /** @return ElementList<IntermediateCatchEvent> */
    public function getIntermediateCatchEvent() : ElementList
    {
        /** @var ElementList<IntermediateCatchEvent> $elements */
        $elements = new ElementList($this->getChilds('intermediateCatchEvent'));

        return $elements;
    }

    public function hasIntermediateCatchEvent() : bool
    {
        return $this->hasChild('intermediateCatchEvent');
    }

    /** @return ElementList<IntermediateThrowEvent> */
    public function getIntermediateThrowEvent() : ElementList
    {
        /** @var ElementList<IntermediateThrowEvent> $elements */
        $elements = new ElementList($this->getChilds('intermediateThrowEvent'));

        return $elements;
    }

    public function hasIntermediateThrowEvent() : bool
    {
        return $this->hasChild('intermediateThrowEvent');
    }

    /** @return ElementList<ManualTask> */
    public function getManualTask() : ElementList
    {
        /** @var ElementList<ManualTask> $elements */
        $elements = new ElementList($this->getChilds('manualTask'));

        return $elements;
    }

    public function hasManualTask() : bool
    {
        return $this->hasChild('manualTask');
    }

    /** @return ElementList<ParallelGateway> */
    public function getParallelGateway() : ElementList
    {
        /** @var ElementList<ParallelGateway> $elements */
        $elements = new ElementList($this->getChilds('parallelGateway'));

        return $elements;
    }

    public function hasParallelGateway() : bool
    {
        return $this->hasChild('parallelGateway');
    }

    /** @return ElementList<ReceiveTask> */
    public function getReceiveTask() : ElementList
    {
        /** @var ElementList<ReceiveTask> $elements */
        $elements = new ElementList($this->getChilds('receiveTask'));

        return $elements;
    }

    public function hasReceiveTask() : bool
    {
        return $this->hasChild('receiveTask');
    }

    /** @return ElementList<ScriptTask> */
    public function getScriptTask() : ElementList
    {
        /** @var ElementList<ScriptTask> $elements */
        $elements = new ElementList($this->getChilds('scriptTask'));

        return $elements;
    }

    public function hasScriptTask() : bool
    {
        return $this->hasChild('scriptTask');
    }

    /** @return ElementList<SendTask> */
    public function getSendTask() : ElementList
    {
        /** @var ElementList<SendTask> $elements */
        $elements = new ElementList($this->getChilds('sendTask'));

        return $elements;
    }

    public function hasSendTask() : bool
    {
        return $this->hasChild('sendTask');
    }

    /** @return ElementList<SequenceFlow> */
    public function getSequenceFlow() : ElementList
    {
        /** @var ElementList<SequenceFlow> $elements */
        $elements = new ElementList($this->getChilds('sequenceFlow'));

        return $elements;
    }

    public function hasSequenceFlow() : bool
    {
        return $this->hasChild('sequenceFlow');
    }

    /** @return ElementList<ServiceTask> */
    public function getServiceTask() : ElementList
    {
        /** @var ElementList<ServiceTask> $elements */
        $elements = new ElementList($this->getChilds('serviceTask'));

        return $elements;
    }

    public function hasServiceTask() : bool
    {
        return $this->hasChild('serviceTask');
    }

    /** @return ElementList<StartEvent> */
    public function getStartEvent() : ElementList
    {
        /** @var ElementList<StartEvent> $elements */
        $elements = new ElementList($this->getChilds('startEvent'));

        return $elements;
    }

    public function hasStartEvent() : bool
    {
        return $this->hasChild('startEvent');
    }

    /** @return ElementList<SubChoreography> */
    public function getSubChoreography() : ElementList
    {
        /** @var ElementList<SubChoreography> $elements */
        $elements = new ElementList($this->getChilds('subChoreography'));

        return $elements;
    }

    public function hasSubChoreography() : bool
    {
        return $this->hasChild('subChoreography');
    }

    /** @return ElementList<SubProcess> */
    public function getSubProcess() : ElementList
    {
        /** @var ElementList<SubProcess> $elements */
        $elements = new ElementList($this->getChilds('subProcess'));

        return $elements;
    }

    public function hasSubProcess() : bool
    {
        return $this->hasChild('subProcess');
    }

    /** @return ElementList<Task> */
    public function getTask() : ElementList
    {
        /** @var ElementList<Task> $elements */
        $elements = new ElementList($this->getChilds('task'));

        return $elements;
    }

    public function hasTask() : bool
    {
        return $this->hasChild('task');
    }

    /** @return ElementList<Transaction> */
    public function getTransaction() : ElementList
    {
        /** @var ElementList<Transaction> $elements */
        $elements = new ElementList($this->getChilds('transaction'));

        return $elements;
    }

    public function hasTransaction() : bool
    {
        return $this->hasChild('transaction');
    }

    /** @return ElementList<UserTask> */
    public function getUserTask() : ElementList
    {
        /** @var ElementList<UserTask> $elements */
        $elements = new ElementList($this->getChilds('userTask'));

        return $elements;
    }

    public function hasUserTask() : bool
    {
        return $this->hasChild('userTask');
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
}
