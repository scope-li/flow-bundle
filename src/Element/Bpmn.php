<?php

namespace Scopeli\FlowBundle\Element;

use DOMElement;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Scopeli\FlowBundle\Exception\BpmnElementNotFoundByIdException;
use Scopeli\FlowBundle\Exception\LogicException;
use Scopeli\FlowBundle\Exception\RuntimeException;

class Bpmn extends DOMDocument
{
    /**
     * @return ElementList<AbstractElement>
     */
    public function query(string $expression): ElementList
    {
        $elements = (new DOMXPath($this))->query($expression);

        $buffer = [];
        if ($elements instanceof DOMNodeList) {
            /** @var DOMElement $element */
            foreach ($elements as $element) {
                $buffer[] = $this->createAbstractElement($element, $this);
            }
        }

        return new ElementList($buffer);
    }

    public function findById(string $id): ?AbstractElement
    {
        $elements = $this->query(sprintf('//*[@id="%s"]', $id));

        return $elements->find($id);
    }

    /**
     * @return ElementList<AbstractElement>
     */
    public function findByMessageRef(string $id): ElementList
    {
        return $this->query(sprintf('//*[@messageRef="%s"]', $id));
    }

    public function getById(string $id): AbstractElement
    {
        $element = $this->findById($id);

        if ($element instanceof AbstractElement) {
            return $element;
        }

        throw new BpmnElementNotFoundByIdException($id);
    }

    public function getFlowNodeById(string $id): FlowNode
    {
        $element = $this->findById($id);

        if ($element instanceof FlowNode) {
            return $element;
        }

        throw new LogicException(sprintf('Element with id "%s" is no flowNode.', $id));
    }

    public function getFlowElementById(string $id): FlowElement
    {
        $element = $this->findById($id);

        if ($element instanceof FlowElement) {
            return $element;
        }

        throw new LogicException(sprintf('Element with id "%s" is no flowNode.', $id));
    }

    public function getMessageByName(string $name): Message
    {
        /** @var Message $message */
        foreach ($this->findAllMessage() as $message) {
            if ($name === $message->getName()) {
                return $message;
            }
        }

        throw new RuntimeException(sprintf('No message with name "%s" found.', $name));
    }

    /**
     * @param string[] $cache
     */
    public function isLeadsTo(FlowNode $source, FlowNode $target, array $cache = []): bool
    {
        if ($source->getId() === $target->getId()) {
            return true;
        }

        $found = false;

        $cache[] = $source->getId();
        /** @var SequenceFlow $outgoing */
        foreach ($source->getOutgoing() as $outgoing) {
            $target = $outgoing->getTargetRef();
            assert($target instanceof FlowNode);

            if (!in_array($target->getId(), $cache)) {
                $found = $target->getId() === $target->getId() || $this->isLeadsTo($target, $target, $cache);

                if ($found) {
                    break;
                }
            }
        }

        return $found;
    }

    /** @return ElementList<Activity> */
    public function findAllActivity(): ElementList
    {
        /** @var ElementList<Activity> $buffer */
        $buffer = $this->findAll(lcfirst('Activity'));

        return $buffer;
    }

    public function findActivity(string $id): ?Activity
    {
        /** @var Activity|null $buffer */
        $buffer = $this->find('Activity', $id);

        return $buffer;
    }

    public function getActivity(string $id): Activity
    {
        /** @var Activity $buffer */
        $buffer = $this->get('Activity', $id);

        return $buffer;
    }

    /** @return ElementList<AdHocSubProcess> */
    public function findAllAdHocSubProcess(): ElementList
    {
        /** @var ElementList<AdHocSubProcess> $buffer */
        $buffer = $this->findAll(lcfirst('AdHocSubProcess'));

        return $buffer;
    }

    public function findAdHocSubProcess(string $id): ?AdHocSubProcess
    {
        /** @var AdHocSubProcess|null $buffer */
        $buffer = $this->find('AdHocSubProcess', $id);

        return $buffer;
    }

    public function getAdHocSubProcess(string $id): AdHocSubProcess
    {
        /** @var AdHocSubProcess $buffer */
        $buffer = $this->get('AdHocSubProcess', $id);

        return $buffer;
    }

    /** @return ElementList<Artifact> */
    public function findAllArtifact(): ElementList
    {
        /** @var ElementList<Artifact> $buffer */
        $buffer = $this->findAll(lcfirst('Artifact'));

        return $buffer;
    }

    public function findArtifact(string $id): ?Artifact
    {
        /** @var Artifact|null $buffer */
        $buffer = $this->find('Artifact', $id);

        return $buffer;
    }

    public function getArtifact(string $id): Artifact
    {
        /** @var Artifact $buffer */
        $buffer = $this->get('Artifact', $id);

        return $buffer;
    }

    /** @return ElementList<Assignment> */
    public function findAllAssignment(): ElementList
    {
        /** @var ElementList<Assignment> $buffer */
        $buffer = $this->findAll(lcfirst('Assignment'));

        return $buffer;
    }

    public function findAssignment(string $id): ?Assignment
    {
        /** @var Assignment|null $buffer */
        $buffer = $this->find('Assignment', $id);

        return $buffer;
    }

    public function getAssignment(string $id): Assignment
    {
        /** @var Assignment $buffer */
        $buffer = $this->get('Assignment', $id);

        return $buffer;
    }

    /** @return ElementList<Association> */
    public function findAllAssociation(): ElementList
    {
        /** @var ElementList<Association> $buffer */
        $buffer = $this->findAll(lcfirst('Association'));

        return $buffer;
    }

    public function findAssociation(string $id): ?Association
    {
        /** @var Association|null $buffer */
        $buffer = $this->find('Association', $id);

        return $buffer;
    }

    public function getAssociation(string $id): Association
    {
        /** @var Association $buffer */
        $buffer = $this->get('Association', $id);

        return $buffer;
    }

    /** @return ElementList<Auditing> */
    public function findAllAuditing(): ElementList
    {
        /** @var ElementList<Auditing> $buffer */
        $buffer = $this->findAll(lcfirst('Auditing'));

        return $buffer;
    }

    public function findAuditing(string $id): ?Auditing
    {
        /** @var Auditing|null $buffer */
        $buffer = $this->find('Auditing', $id);

        return $buffer;
    }

    public function getAuditing(string $id): Auditing
    {
        /** @var Auditing $buffer */
        $buffer = $this->get('Auditing', $id);

        return $buffer;
    }

    /** @return ElementList<BaseElement> */
    public function findAllBaseElement(): ElementList
    {
        /** @var ElementList<BaseElement> $buffer */
        $buffer = $this->findAll(lcfirst('BaseElement'));

        return $buffer;
    }

    public function findBaseElement(string $id): ?BaseElement
    {
        /** @var BaseElement|null $buffer */
        $buffer = $this->find('BaseElement', $id);

        return $buffer;
    }

    public function getBaseElement(string $id): BaseElement
    {
        /** @var BaseElement $buffer */
        $buffer = $this->get('BaseElement', $id);

        return $buffer;
    }

    /** @return ElementList<BaseElementWithMixedContent> */
    public function findAllBaseElementWithMixedContent(): ElementList
    {
        /** @var ElementList<BaseElementWithMixedContent> $buffer */
        $buffer = $this->findAll(lcfirst('BaseElementWithMixedContent'));

        return $buffer;
    }

    public function findBaseElementWithMixedContent(string $id): ?BaseElementWithMixedContent
    {
        /** @var BaseElementWithMixedContent|null $buffer */
        $buffer = $this->find('BaseElementWithMixedContent', $id);

        return $buffer;
    }

    public function getBaseElementWithMixedContent(string $id): BaseElementWithMixedContent
    {
        /** @var BaseElementWithMixedContent $buffer */
        $buffer = $this->get('BaseElementWithMixedContent', $id);

        return $buffer;
    }

    /** @return ElementList<BoundaryEvent> */
    public function findAllBoundaryEvent(): ElementList
    {
        /** @var ElementList<BoundaryEvent> $buffer */
        $buffer = $this->findAll(lcfirst('BoundaryEvent'));

        return $buffer;
    }

    public function findBoundaryEvent(string $id): ?BoundaryEvent
    {
        /** @var BoundaryEvent|null $buffer */
        $buffer = $this->find('BoundaryEvent', $id);

        return $buffer;
    }

    public function getBoundaryEvent(string $id): BoundaryEvent
    {
        /** @var BoundaryEvent $buffer */
        $buffer = $this->get('BoundaryEvent', $id);

        return $buffer;
    }

    /** @return ElementList<BusinessRuleTask> */
    public function findAllBusinessRuleTask(): ElementList
    {
        /** @var ElementList<BusinessRuleTask> $buffer */
        $buffer = $this->findAll(lcfirst('BusinessRuleTask'));

        return $buffer;
    }

    public function findBusinessRuleTask(string $id): ?BusinessRuleTask
    {
        /** @var BusinessRuleTask|null $buffer */
        $buffer = $this->find('BusinessRuleTask', $id);

        return $buffer;
    }

    public function getBusinessRuleTask(string $id): BusinessRuleTask
    {
        /** @var BusinessRuleTask $buffer */
        $buffer = $this->get('BusinessRuleTask', $id);

        return $buffer;
    }

    /** @return ElementList<CallableElement> */
    public function findAllCallableElement(): ElementList
    {
        /** @var ElementList<CallableElement> $buffer */
        $buffer = $this->findAll(lcfirst('CallableElement'));

        return $buffer;
    }

    public function findCallableElement(string $id): ?CallableElement
    {
        /** @var CallableElement|null $buffer */
        $buffer = $this->find('CallableElement', $id);

        return $buffer;
    }

    public function getCallableElement(string $id): CallableElement
    {
        /** @var CallableElement $buffer */
        $buffer = $this->get('CallableElement', $id);

        return $buffer;
    }

    /** @return ElementList<CallActivity> */
    public function findAllCallActivity(): ElementList
    {
        /** @var ElementList<CallActivity> $buffer */
        $buffer = $this->findAll(lcfirst('CallActivity'));

        return $buffer;
    }

    public function findCallActivity(string $id): ?CallActivity
    {
        /** @var CallActivity|null $buffer */
        $buffer = $this->find('CallActivity', $id);

        return $buffer;
    }

    public function getCallActivity(string $id): CallActivity
    {
        /** @var CallActivity $buffer */
        $buffer = $this->get('CallActivity', $id);

        return $buffer;
    }

    /** @return ElementList<CallChoreography> */
    public function findAllCallChoreography(): ElementList
    {
        /** @var ElementList<CallChoreography> $buffer */
        $buffer = $this->findAll(lcfirst('CallChoreography'));

        return $buffer;
    }

    public function findCallChoreography(string $id): ?CallChoreography
    {
        /** @var CallChoreography|null $buffer */
        $buffer = $this->find('CallChoreography', $id);

        return $buffer;
    }

    public function getCallChoreography(string $id): CallChoreography
    {
        /** @var CallChoreography $buffer */
        $buffer = $this->get('CallChoreography', $id);

        return $buffer;
    }

    /** @return ElementList<CallConversation> */
    public function findAllCallConversation(): ElementList
    {
        /** @var ElementList<CallConversation> $buffer */
        $buffer = $this->findAll(lcfirst('CallConversation'));

        return $buffer;
    }

    public function findCallConversation(string $id): ?CallConversation
    {
        /** @var CallConversation|null $buffer */
        $buffer = $this->find('CallConversation', $id);

        return $buffer;
    }

    public function getCallConversation(string $id): CallConversation
    {
        /** @var CallConversation $buffer */
        $buffer = $this->get('CallConversation', $id);

        return $buffer;
    }

    /** @return ElementList<CancelEventDefinition> */
    public function findAllCancelEventDefinition(): ElementList
    {
        /** @var ElementList<CancelEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('CancelEventDefinition'));

        return $buffer;
    }

    public function findCancelEventDefinition(string $id): ?CancelEventDefinition
    {
        /** @var CancelEventDefinition|null $buffer */
        $buffer = $this->find('CancelEventDefinition', $id);

        return $buffer;
    }

    public function getCancelEventDefinition(string $id): CancelEventDefinition
    {
        /** @var CancelEventDefinition $buffer */
        $buffer = $this->get('CancelEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<CatchEvent> */
    public function findAllCatchEvent(): ElementList
    {
        /** @var ElementList<CatchEvent> $buffer */
        $buffer = $this->findAll(lcfirst('CatchEvent'));

        return $buffer;
    }

    public function findCatchEvent(string $id): ?CatchEvent
    {
        /** @var CatchEvent|null $buffer */
        $buffer = $this->find('CatchEvent', $id);

        return $buffer;
    }

    public function getCatchEvent(string $id): CatchEvent
    {
        /** @var CatchEvent $buffer */
        $buffer = $this->get('CatchEvent', $id);

        return $buffer;
    }

    /** @return ElementList<Category> */
    public function findAllCategory(): ElementList
    {
        /** @var ElementList<Category> $buffer */
        $buffer = $this->findAll(lcfirst('Category'));

        return $buffer;
    }

    public function findCategory(string $id): ?Category
    {
        /** @var Category|null $buffer */
        $buffer = $this->find('Category', $id);

        return $buffer;
    }

    public function getCategory(string $id): Category
    {
        /** @var Category $buffer */
        $buffer = $this->get('Category', $id);

        return $buffer;
    }

    /** @return ElementList<CategoryValue> */
    public function findAllCategoryValue(): ElementList
    {
        /** @var ElementList<CategoryValue> $buffer */
        $buffer = $this->findAll(lcfirst('CategoryValue'));

        return $buffer;
    }

    public function findCategoryValue(string $id): ?CategoryValue
    {
        /** @var CategoryValue|null $buffer */
        $buffer = $this->find('CategoryValue', $id);

        return $buffer;
    }

    public function getCategoryValue(string $id): CategoryValue
    {
        /** @var CategoryValue $buffer */
        $buffer = $this->get('CategoryValue', $id);

        return $buffer;
    }

    /** @return ElementList<Choreography> */
    public function findAllChoreography(): ElementList
    {
        /** @var ElementList<Choreography> $buffer */
        $buffer = $this->findAll(lcfirst('Choreography'));

        return $buffer;
    }

    public function findChoreography(string $id): ?Choreography
    {
        /** @var Choreography|null $buffer */
        $buffer = $this->find('Choreography', $id);

        return $buffer;
    }

    public function getChoreography(string $id): Choreography
    {
        /** @var Choreography $buffer */
        $buffer = $this->get('Choreography', $id);

        return $buffer;
    }

    /** @return ElementList<ChoreographyActivity> */
    public function findAllChoreographyActivity(): ElementList
    {
        /** @var ElementList<ChoreographyActivity> $buffer */
        $buffer = $this->findAll(lcfirst('ChoreographyActivity'));

        return $buffer;
    }

    public function findChoreographyActivity(string $id): ?ChoreographyActivity
    {
        /** @var ChoreographyActivity|null $buffer */
        $buffer = $this->find('ChoreographyActivity', $id);

        return $buffer;
    }

    public function getChoreographyActivity(string $id): ChoreographyActivity
    {
        /** @var ChoreographyActivity $buffer */
        $buffer = $this->get('ChoreographyActivity', $id);

        return $buffer;
    }

    /** @return ElementList<ChoreographyTask> */
    public function findAllChoreographyTask(): ElementList
    {
        /** @var ElementList<ChoreographyTask> $buffer */
        $buffer = $this->findAll(lcfirst('ChoreographyTask'));

        return $buffer;
    }

    public function findChoreographyTask(string $id): ?ChoreographyTask
    {
        /** @var ChoreographyTask|null $buffer */
        $buffer = $this->find('ChoreographyTask', $id);

        return $buffer;
    }

    public function getChoreographyTask(string $id): ChoreographyTask
    {
        /** @var ChoreographyTask $buffer */
        $buffer = $this->get('ChoreographyTask', $id);

        return $buffer;
    }

    /** @return ElementList<Collaboration> */
    public function findAllCollaboration(): ElementList
    {
        /** @var ElementList<Collaboration> $buffer */
        $buffer = $this->findAll(lcfirst('Collaboration'));

        return $buffer;
    }

    public function findCollaboration(string $id): ?Collaboration
    {
        /** @var Collaboration|null $buffer */
        $buffer = $this->find('Collaboration', $id);

        return $buffer;
    }

    public function getCollaboration(string $id): Collaboration
    {
        /** @var Collaboration $buffer */
        $buffer = $this->get('Collaboration', $id);

        return $buffer;
    }

    /** @return ElementList<CompensateEventDefinition> */
    public function findAllCompensateEventDefinition(): ElementList
    {
        /** @var ElementList<CompensateEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('CompensateEventDefinition'));

        return $buffer;
    }

    public function findCompensateEventDefinition(string $id): ?CompensateEventDefinition
    {
        /** @var CompensateEventDefinition|null $buffer */
        $buffer = $this->find('CompensateEventDefinition', $id);

        return $buffer;
    }

    public function getCompensateEventDefinition(string $id): CompensateEventDefinition
    {
        /** @var CompensateEventDefinition $buffer */
        $buffer = $this->get('CompensateEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<ComplexBehaviorDefinition> */
    public function findAllComplexBehaviorDefinition(): ElementList
    {
        /** @var ElementList<ComplexBehaviorDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('ComplexBehaviorDefinition'));

        return $buffer;
    }

    public function findComplexBehaviorDefinition(string $id): ?ComplexBehaviorDefinition
    {
        /** @var ComplexBehaviorDefinition|null $buffer */
        $buffer = $this->find('ComplexBehaviorDefinition', $id);

        return $buffer;
    }

    public function getComplexBehaviorDefinition(string $id): ComplexBehaviorDefinition
    {
        /** @var ComplexBehaviorDefinition $buffer */
        $buffer = $this->get('ComplexBehaviorDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<ComplexGateway> */
    public function findAllComplexGateway(): ElementList
    {
        /** @var ElementList<ComplexGateway> $buffer */
        $buffer = $this->findAll(lcfirst('ComplexGateway'));

        return $buffer;
    }

    public function findComplexGateway(string $id): ?ComplexGateway
    {
        /** @var ComplexGateway|null $buffer */
        $buffer = $this->find('ComplexGateway', $id);

        return $buffer;
    }

    public function getComplexGateway(string $id): ComplexGateway
    {
        /** @var ComplexGateway $buffer */
        $buffer = $this->get('ComplexGateway', $id);

        return $buffer;
    }

    /** @return ElementList<ConditionalEventDefinition> */
    public function findAllConditionalEventDefinition(): ElementList
    {
        /** @var ElementList<ConditionalEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('ConditionalEventDefinition'));

        return $buffer;
    }

    public function findConditionalEventDefinition(string $id): ?ConditionalEventDefinition
    {
        /** @var ConditionalEventDefinition|null $buffer */
        $buffer = $this->find('ConditionalEventDefinition', $id);

        return $buffer;
    }

    public function getConditionalEventDefinition(string $id): ConditionalEventDefinition
    {
        /** @var ConditionalEventDefinition $buffer */
        $buffer = $this->get('ConditionalEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<Conversation> */
    public function findAllConversation(): ElementList
    {
        /** @var ElementList<Conversation> $buffer */
        $buffer = $this->findAll(lcfirst('Conversation'));

        return $buffer;
    }

    public function findConversation(string $id): ?Conversation
    {
        /** @var Conversation|null $buffer */
        $buffer = $this->find('Conversation', $id);

        return $buffer;
    }

    public function getConversation(string $id): Conversation
    {
        /** @var Conversation $buffer */
        $buffer = $this->get('Conversation', $id);

        return $buffer;
    }

    /** @return ElementList<ConversationAssociation> */
    public function findAllConversationAssociation(): ElementList
    {
        /** @var ElementList<ConversationAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('ConversationAssociation'));

        return $buffer;
    }

    public function findConversationAssociation(string $id): ?ConversationAssociation
    {
        /** @var ConversationAssociation|null $buffer */
        $buffer = $this->find('ConversationAssociation', $id);

        return $buffer;
    }

    public function getConversationAssociation(string $id): ConversationAssociation
    {
        /** @var ConversationAssociation $buffer */
        $buffer = $this->get('ConversationAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<ConversationLink> */
    public function findAllConversationLink(): ElementList
    {
        /** @var ElementList<ConversationLink> $buffer */
        $buffer = $this->findAll(lcfirst('ConversationLink'));

        return $buffer;
    }

    public function findConversationLink(string $id): ?ConversationLink
    {
        /** @var ConversationLink|null $buffer */
        $buffer = $this->find('ConversationLink', $id);

        return $buffer;
    }

    public function getConversationLink(string $id): ConversationLink
    {
        /** @var ConversationLink $buffer */
        $buffer = $this->get('ConversationLink', $id);

        return $buffer;
    }

    /** @return ElementList<ConversationNode> */
    public function findAllConversationNode(): ElementList
    {
        /** @var ElementList<ConversationNode> $buffer */
        $buffer = $this->findAll(lcfirst('ConversationNode'));

        return $buffer;
    }

    public function findConversationNode(string $id): ?ConversationNode
    {
        /** @var ConversationNode|null $buffer */
        $buffer = $this->find('ConversationNode', $id);

        return $buffer;
    }

    public function getConversationNode(string $id): ConversationNode
    {
        /** @var ConversationNode $buffer */
        $buffer = $this->get('ConversationNode', $id);

        return $buffer;
    }

    /** @return ElementList<CorrelationKey> */
    public function findAllCorrelationKey(): ElementList
    {
        /** @var ElementList<CorrelationKey> $buffer */
        $buffer = $this->findAll(lcfirst('CorrelationKey'));

        return $buffer;
    }

    public function findCorrelationKey(string $id): ?CorrelationKey
    {
        /** @var CorrelationKey|null $buffer */
        $buffer = $this->find('CorrelationKey', $id);

        return $buffer;
    }

    public function getCorrelationKey(string $id): CorrelationKey
    {
        /** @var CorrelationKey $buffer */
        $buffer = $this->get('CorrelationKey', $id);

        return $buffer;
    }

    /** @return ElementList<CorrelationProperty> */
    public function findAllCorrelationProperty(): ElementList
    {
        /** @var ElementList<CorrelationProperty> $buffer */
        $buffer = $this->findAll(lcfirst('CorrelationProperty'));

        return $buffer;
    }

    public function findCorrelationProperty(string $id): ?CorrelationProperty
    {
        /** @var CorrelationProperty|null $buffer */
        $buffer = $this->find('CorrelationProperty', $id);

        return $buffer;
    }

    public function getCorrelationProperty(string $id): CorrelationProperty
    {
        /** @var CorrelationProperty $buffer */
        $buffer = $this->get('CorrelationProperty', $id);

        return $buffer;
    }

    /** @return ElementList<CorrelationPropertyBinding> */
    public function findAllCorrelationPropertyBinding(): ElementList
    {
        /** @var ElementList<CorrelationPropertyBinding> $buffer */
        $buffer = $this->findAll(lcfirst('CorrelationPropertyBinding'));

        return $buffer;
    }

    public function findCorrelationPropertyBinding(string $id): ?CorrelationPropertyBinding
    {
        /** @var CorrelationPropertyBinding|null $buffer */
        $buffer = $this->find('CorrelationPropertyBinding', $id);

        return $buffer;
    }

    public function getCorrelationPropertyBinding(string $id): CorrelationPropertyBinding
    {
        /** @var CorrelationPropertyBinding $buffer */
        $buffer = $this->get('CorrelationPropertyBinding', $id);

        return $buffer;
    }

    /** @return ElementList<CorrelationPropertyRetrievalExpression> */
    public function findAllCorrelationPropertyRetrievalExpression(): ElementList
    {
        /** @var ElementList<CorrelationPropertyRetrievalExpression> $buffer */
        $buffer = $this->findAll(lcfirst('CorrelationPropertyRetrievalExpression'));

        return $buffer;
    }

    public function findCorrelationPropertyRetrievalExpression(string $id): ?CorrelationPropertyRetrievalExpression
    {
        /** @var CorrelationPropertyRetrievalExpression|null $buffer */
        $buffer = $this->find('CorrelationPropertyRetrievalExpression', $id);

        return $buffer;
    }

    public function getCorrelationPropertyRetrievalExpression(string $id): CorrelationPropertyRetrievalExpression
    {
        /** @var CorrelationPropertyRetrievalExpression $buffer */
        $buffer = $this->get('CorrelationPropertyRetrievalExpression', $id);

        return $buffer;
    }

    /** @return ElementList<CorrelationSubscription> */
    public function findAllCorrelationSubscription(): ElementList
    {
        /** @var ElementList<CorrelationSubscription> $buffer */
        $buffer = $this->findAll(lcfirst('CorrelationSubscription'));

        return $buffer;
    }

    public function findCorrelationSubscription(string $id): ?CorrelationSubscription
    {
        /** @var CorrelationSubscription|null $buffer */
        $buffer = $this->find('CorrelationSubscription', $id);

        return $buffer;
    }

    public function getCorrelationSubscription(string $id): CorrelationSubscription
    {
        /** @var CorrelationSubscription $buffer */
        $buffer = $this->get('CorrelationSubscription', $id);

        return $buffer;
    }

    /** @return ElementList<DataAssociation> */
    public function findAllDataAssociation(): ElementList
    {
        /** @var ElementList<DataAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('DataAssociation'));

        return $buffer;
    }

    public function findDataAssociation(string $id): ?DataAssociation
    {
        /** @var DataAssociation|null $buffer */
        $buffer = $this->find('DataAssociation', $id);

        return $buffer;
    }

    public function getDataAssociation(string $id): DataAssociation
    {
        /** @var DataAssociation $buffer */
        $buffer = $this->get('DataAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<DataInput> */
    public function findAllDataInput(): ElementList
    {
        /** @var ElementList<DataInput> $buffer */
        $buffer = $this->findAll(lcfirst('DataInput'));

        return $buffer;
    }

    public function findDataInput(string $id): ?DataInput
    {
        /** @var DataInput|null $buffer */
        $buffer = $this->find('DataInput', $id);

        return $buffer;
    }

    public function getDataInput(string $id): DataInput
    {
        /** @var DataInput $buffer */
        $buffer = $this->get('DataInput', $id);

        return $buffer;
    }

    /** @return ElementList<DataInputAssociation> */
    public function findAllDataInputAssociation(): ElementList
    {
        /** @var ElementList<DataInputAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('DataInputAssociation'));

        return $buffer;
    }

    public function findDataInputAssociation(string $id): ?DataInputAssociation
    {
        /** @var DataInputAssociation|null $buffer */
        $buffer = $this->find('DataInputAssociation', $id);

        return $buffer;
    }

    public function getDataInputAssociation(string $id): DataInputAssociation
    {
        /** @var DataInputAssociation $buffer */
        $buffer = $this->get('DataInputAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<DataObject> */
    public function findAllDataObject(): ElementList
    {
        /** @var ElementList<DataObject> $buffer */
        $buffer = $this->findAll(lcfirst('DataObject'));

        return $buffer;
    }

    public function findDataObject(string $id): ?DataObject
    {
        /** @var DataObject|null $buffer */
        $buffer = $this->find('DataObject', $id);

        return $buffer;
    }

    public function getDataObject(string $id): DataObject
    {
        /** @var DataObject $buffer */
        $buffer = $this->get('DataObject', $id);

        return $buffer;
    }

    /** @return ElementList<DataObjectReference> */
    public function findAllDataObjectReference(): ElementList
    {
        /** @var ElementList<DataObjectReference> $buffer */
        $buffer = $this->findAll(lcfirst('DataObjectReference'));

        return $buffer;
    }

    public function findDataObjectReference(string $id): ?DataObjectReference
    {
        /** @var DataObjectReference|null $buffer */
        $buffer = $this->find('DataObjectReference', $id);

        return $buffer;
    }

    public function getDataObjectReference(string $id): DataObjectReference
    {
        /** @var DataObjectReference $buffer */
        $buffer = $this->get('DataObjectReference', $id);

        return $buffer;
    }

    /** @return ElementList<DataOutput> */
    public function findAllDataOutput(): ElementList
    {
        /** @var ElementList<DataOutput> $buffer */
        $buffer = $this->findAll(lcfirst('DataOutput'));

        return $buffer;
    }

    public function findDataOutput(string $id): ?DataOutput
    {
        /** @var DataOutput|null $buffer */
        $buffer = $this->find('DataOutput', $id);

        return $buffer;
    }

    public function getDataOutput(string $id): DataOutput
    {
        /** @var DataOutput $buffer */
        $buffer = $this->get('DataOutput', $id);

        return $buffer;
    }

    /** @return ElementList<DataOutputAssociation> */
    public function findAllDataOutputAssociation(): ElementList
    {
        /** @var ElementList<DataOutputAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('DataOutputAssociation'));

        return $buffer;
    }

    public function findDataOutputAssociation(string $id): ?DataOutputAssociation
    {
        /** @var DataOutputAssociation|null $buffer */
        $buffer = $this->find('DataOutputAssociation', $id);

        return $buffer;
    }

    public function getDataOutputAssociation(string $id): DataOutputAssociation
    {
        /** @var DataOutputAssociation $buffer */
        $buffer = $this->get('DataOutputAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<DataState> */
    public function findAllDataState(): ElementList
    {
        /** @var ElementList<DataState> $buffer */
        $buffer = $this->findAll(lcfirst('DataState'));

        return $buffer;
    }

    public function findDataState(string $id): ?DataState
    {
        /** @var DataState|null $buffer */
        $buffer = $this->find('DataState', $id);

        return $buffer;
    }

    public function getDataState(string $id): DataState
    {
        /** @var DataState $buffer */
        $buffer = $this->get('DataState', $id);

        return $buffer;
    }

    /** @return ElementList<DataStore> */
    public function findAllDataStore(): ElementList
    {
        /** @var ElementList<DataStore> $buffer */
        $buffer = $this->findAll(lcfirst('DataStore'));

        return $buffer;
    }

    public function findDataStore(string $id): ?DataStore
    {
        /** @var DataStore|null $buffer */
        $buffer = $this->find('DataStore', $id);

        return $buffer;
    }

    public function getDataStore(string $id): DataStore
    {
        /** @var DataStore $buffer */
        $buffer = $this->get('DataStore', $id);

        return $buffer;
    }

    /** @return ElementList<DataStoreReference> */
    public function findAllDataStoreReference(): ElementList
    {
        /** @var ElementList<DataStoreReference> $buffer */
        $buffer = $this->findAll(lcfirst('DataStoreReference'));

        return $buffer;
    }

    public function findDataStoreReference(string $id): ?DataStoreReference
    {
        /** @var DataStoreReference|null $buffer */
        $buffer = $this->find('DataStoreReference', $id);

        return $buffer;
    }

    public function getDataStoreReference(string $id): DataStoreReference
    {
        /** @var DataStoreReference $buffer */
        $buffer = $this->get('DataStoreReference', $id);

        return $buffer;
    }

    /** @return ElementList<Documentation> */
    public function findAllDocumentation(): ElementList
    {
        /** @var ElementList<Documentation> $buffer */
        $buffer = $this->findAll(lcfirst('Documentation'));

        return $buffer;
    }

    public function findDocumentation(string $id): ?Documentation
    {
        /** @var Documentation|null $buffer */
        $buffer = $this->find('Documentation', $id);

        return $buffer;
    }

    public function getDocumentation(string $id): Documentation
    {
        /** @var Documentation $buffer */
        $buffer = $this->get('Documentation', $id);

        return $buffer;
    }

    /** @return ElementList<EndEvent> */
    public function findAllEndEvent(): ElementList
    {
        /** @var ElementList<EndEvent> $buffer */
        $buffer = $this->findAll(lcfirst('EndEvent'));

        return $buffer;
    }

    public function findEndEvent(string $id): ?EndEvent
    {
        /** @var EndEvent|null $buffer */
        $buffer = $this->find('EndEvent', $id);

        return $buffer;
    }

    public function getEndEvent(string $id): EndEvent
    {
        /** @var EndEvent $buffer */
        $buffer = $this->get('EndEvent', $id);

        return $buffer;
    }

    /** @return ElementList<EndPoint> */
    public function findAllEndPoint(): ElementList
    {
        /** @var ElementList<EndPoint> $buffer */
        $buffer = $this->findAll(lcfirst('EndPoint'));

        return $buffer;
    }

    public function findEndPoint(string $id): ?EndPoint
    {
        /** @var EndPoint|null $buffer */
        $buffer = $this->find('EndPoint', $id);

        return $buffer;
    }

    public function getEndPoint(string $id): EndPoint
    {
        /** @var EndPoint $buffer */
        $buffer = $this->get('EndPoint', $id);

        return $buffer;
    }

    /** @return ElementList<Error> */
    public function findAllError(): ElementList
    {
        /** @var ElementList<Error> $buffer */
        $buffer = $this->findAll(lcfirst('Error'));

        return $buffer;
    }

    public function findError(string $id): ?Error
    {
        /** @var Error|null $buffer */
        $buffer = $this->find('Error', $id);

        return $buffer;
    }

    public function getError(string $id): Error
    {
        /** @var Error $buffer */
        $buffer = $this->get('Error', $id);

        return $buffer;
    }

    /** @return ElementList<ErrorEventDefinition> */
    public function findAllErrorEventDefinition(): ElementList
    {
        /** @var ElementList<ErrorEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('ErrorEventDefinition'));

        return $buffer;
    }

    public function findErrorEventDefinition(string $id): ?ErrorEventDefinition
    {
        /** @var ErrorEventDefinition|null $buffer */
        $buffer = $this->find('ErrorEventDefinition', $id);

        return $buffer;
    }

    public function getErrorEventDefinition(string $id): ErrorEventDefinition
    {
        /** @var ErrorEventDefinition $buffer */
        $buffer = $this->get('ErrorEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<Escalation> */
    public function findAllEscalation(): ElementList
    {
        /** @var ElementList<Escalation> $buffer */
        $buffer = $this->findAll(lcfirst('Escalation'));

        return $buffer;
    }

    public function findEscalation(string $id): ?Escalation
    {
        /** @var Escalation|null $buffer */
        $buffer = $this->find('Escalation', $id);

        return $buffer;
    }

    public function getEscalation(string $id): Escalation
    {
        /** @var Escalation $buffer */
        $buffer = $this->get('Escalation', $id);

        return $buffer;
    }

    /** @return ElementList<EscalationEventDefinition> */
    public function findAllEscalationEventDefinition(): ElementList
    {
        /** @var ElementList<EscalationEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('EscalationEventDefinition'));

        return $buffer;
    }

    public function findEscalationEventDefinition(string $id): ?EscalationEventDefinition
    {
        /** @var EscalationEventDefinition|null $buffer */
        $buffer = $this->find('EscalationEventDefinition', $id);

        return $buffer;
    }

    public function getEscalationEventDefinition(string $id): EscalationEventDefinition
    {
        /** @var EscalationEventDefinition $buffer */
        $buffer = $this->get('EscalationEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<Event> */
    public function findAllEvent(): ElementList
    {
        /** @var ElementList<Event> $buffer */
        $buffer = $this->findAll(lcfirst('Event'));

        return $buffer;
    }

    public function findEvent(string $id): ?Event
    {
        /** @var Event|null $buffer */
        $buffer = $this->find('Event', $id);

        return $buffer;
    }

    public function getEvent(string $id): Event
    {
        /** @var Event $buffer */
        $buffer = $this->get('Event', $id);

        return $buffer;
    }

    /** @return ElementList<EventBasedGateway> */
    public function findAllEventBasedGateway(): ElementList
    {
        /** @var ElementList<EventBasedGateway> $buffer */
        $buffer = $this->findAll(lcfirst('EventBasedGateway'));

        return $buffer;
    }

    public function findEventBasedGateway(string $id): ?EventBasedGateway
    {
        /** @var EventBasedGateway|null $buffer */
        $buffer = $this->find('EventBasedGateway', $id);

        return $buffer;
    }

    public function getEventBasedGateway(string $id): EventBasedGateway
    {
        /** @var EventBasedGateway $buffer */
        $buffer = $this->get('EventBasedGateway', $id);

        return $buffer;
    }

    /** @return ElementList<EventDefinition> */
    public function findAllEventDefinition(): ElementList
    {
        /** @var ElementList<EventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('EventDefinition'));

        return $buffer;
    }

    public function findEventDefinition(string $id): ?EventDefinition
    {
        /** @var EventDefinition|null $buffer */
        $buffer = $this->find('EventDefinition', $id);

        return $buffer;
    }

    public function getEventDefinition(string $id): EventDefinition
    {
        /** @var EventDefinition $buffer */
        $buffer = $this->get('EventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<ExclusiveGateway> */
    public function findAllExclusiveGateway(): ElementList
    {
        /** @var ElementList<ExclusiveGateway> $buffer */
        $buffer = $this->findAll(lcfirst('ExclusiveGateway'));

        return $buffer;
    }

    public function findExclusiveGateway(string $id): ?ExclusiveGateway
    {
        /** @var ExclusiveGateway|null $buffer */
        $buffer = $this->find('ExclusiveGateway', $id);

        return $buffer;
    }

    public function getExclusiveGateway(string $id): ExclusiveGateway
    {
        /** @var ExclusiveGateway $buffer */
        $buffer = $this->get('ExclusiveGateway', $id);

        return $buffer;
    }

    /** @return ElementList<Expression> */
    public function findAllExpression(): ElementList
    {
        /** @var ElementList<Expression> $buffer */
        $buffer = $this->findAll(lcfirst('Expression'));

        return $buffer;
    }

    public function findExpression(string $id): ?Expression
    {
        /** @var Expression|null $buffer */
        $buffer = $this->find('Expression', $id);

        return $buffer;
    }

    public function getExpression(string $id): Expression
    {
        /** @var Expression $buffer */
        $buffer = $this->get('Expression', $id);

        return $buffer;
    }

    /** @return ElementList<Extension> */
    public function findAllExtension(): ElementList
    {
        /** @var ElementList<Extension> $buffer */
        $buffer = $this->findAll(lcfirst('Extension'));

        return $buffer;
    }

    public function findExtension(string $id): ?Extension
    {
        /** @var Extension|null $buffer */
        $buffer = $this->find('Extension', $id);

        return $buffer;
    }

    public function getExtension(string $id): Extension
    {
        /** @var Extension $buffer */
        $buffer = $this->get('Extension', $id);

        return $buffer;
    }

    /** @return ElementList<ExtensionElements> */
    public function findAllExtensionElements(): ElementList
    {
        /** @var ElementList<ExtensionElements> $buffer */
        $buffer = $this->findAll(lcfirst('ExtensionElements'));

        return $buffer;
    }

    public function findExtensionElements(string $id): ?ExtensionElements
    {
        /** @var ExtensionElements|null $buffer */
        $buffer = $this->find('ExtensionElements', $id);

        return $buffer;
    }

    public function getExtensionElements(string $id): ExtensionElements
    {
        /** @var ExtensionElements $buffer */
        $buffer = $this->get('ExtensionElements', $id);

        return $buffer;
    }

    /** @return ElementList<FlowElement> */
    public function findAllFlowElement(): ElementList
    {
        /** @var ElementList<FlowElement> $buffer */
        $buffer = $this->findAll(lcfirst('FlowElement'));

        return $buffer;
    }

    public function findFlowElement(string $id): ?FlowElement
    {
        /** @var FlowElement|null $buffer */
        $buffer = $this->find('FlowElement', $id);

        return $buffer;
    }

    public function getFlowElement(string $id): FlowElement
    {
        /** @var FlowElement $buffer */
        $buffer = $this->get('FlowElement', $id);

        return $buffer;
    }

    /** @return ElementList<FlowNode> */
    public function findAllFlowNode(): ElementList
    {
        /** @var ElementList<FlowNode> $buffer */
        $buffer = $this->findAll(lcfirst('FlowNode'));

        return $buffer;
    }

    public function findFlowNode(string $id): ?FlowNode
    {
        /** @var FlowNode|null $buffer */
        $buffer = $this->find('FlowNode', $id);

        return $buffer;
    }

    public function getFlowNode(string $id): FlowNode
    {
        /** @var FlowNode $buffer */
        $buffer = $this->get('FlowNode', $id);

        return $buffer;
    }

    /** @return ElementList<FormalExpression> */
    public function findAllFormalExpression(): ElementList
    {
        /** @var ElementList<FormalExpression> $buffer */
        $buffer = $this->findAll(lcfirst('FormalExpression'));

        return $buffer;
    }

    public function findFormalExpression(string $id): ?FormalExpression
    {
        /** @var FormalExpression|null $buffer */
        $buffer = $this->find('FormalExpression', $id);

        return $buffer;
    }

    public function getFormalExpression(string $id): FormalExpression
    {
        /** @var FormalExpression $buffer */
        $buffer = $this->get('FormalExpression', $id);

        return $buffer;
    }

    /** @return ElementList<Gateway> */
    public function findAllGateway(): ElementList
    {
        /** @var ElementList<Gateway> $buffer */
        $buffer = $this->findAll(lcfirst('Gateway'));

        return $buffer;
    }

    public function findGateway(string $id): ?Gateway
    {
        /** @var Gateway|null $buffer */
        $buffer = $this->find('Gateway', $id);

        return $buffer;
    }

    public function getGateway(string $id): Gateway
    {
        /** @var Gateway $buffer */
        $buffer = $this->get('Gateway', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalBusinessRuleTask> */
    public function findAllGlobalBusinessRuleTask(): ElementList
    {
        /** @var ElementList<GlobalBusinessRuleTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalBusinessRuleTask'));

        return $buffer;
    }

    public function findGlobalBusinessRuleTask(string $id): ?GlobalBusinessRuleTask
    {
        /** @var GlobalBusinessRuleTask|null $buffer */
        $buffer = $this->find('GlobalBusinessRuleTask', $id);

        return $buffer;
    }

    public function getGlobalBusinessRuleTask(string $id): GlobalBusinessRuleTask
    {
        /** @var GlobalBusinessRuleTask $buffer */
        $buffer = $this->get('GlobalBusinessRuleTask', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalChoreographyTask> */
    public function findAllGlobalChoreographyTask(): ElementList
    {
        /** @var ElementList<GlobalChoreographyTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalChoreographyTask'));

        return $buffer;
    }

    public function findGlobalChoreographyTask(string $id): ?GlobalChoreographyTask
    {
        /** @var GlobalChoreographyTask|null $buffer */
        $buffer = $this->find('GlobalChoreographyTask', $id);

        return $buffer;
    }

    public function getGlobalChoreographyTask(string $id): GlobalChoreographyTask
    {
        /** @var GlobalChoreographyTask $buffer */
        $buffer = $this->get('GlobalChoreographyTask', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalConversation> */
    public function findAllGlobalConversation(): ElementList
    {
        /** @var ElementList<GlobalConversation> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalConversation'));

        return $buffer;
    }

    public function findGlobalConversation(string $id): ?GlobalConversation
    {
        /** @var GlobalConversation|null $buffer */
        $buffer = $this->find('GlobalConversation', $id);

        return $buffer;
    }

    public function getGlobalConversation(string $id): GlobalConversation
    {
        /** @var GlobalConversation $buffer */
        $buffer = $this->get('GlobalConversation', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalManualTask> */
    public function findAllGlobalManualTask(): ElementList
    {
        /** @var ElementList<GlobalManualTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalManualTask'));

        return $buffer;
    }

    public function findGlobalManualTask(string $id): ?GlobalManualTask
    {
        /** @var GlobalManualTask|null $buffer */
        $buffer = $this->find('GlobalManualTask', $id);

        return $buffer;
    }

    public function getGlobalManualTask(string $id): GlobalManualTask
    {
        /** @var GlobalManualTask $buffer */
        $buffer = $this->get('GlobalManualTask', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalScriptTask> */
    public function findAllGlobalScriptTask(): ElementList
    {
        /** @var ElementList<GlobalScriptTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalScriptTask'));

        return $buffer;
    }

    public function findGlobalScriptTask(string $id): ?GlobalScriptTask
    {
        /** @var GlobalScriptTask|null $buffer */
        $buffer = $this->find('GlobalScriptTask', $id);

        return $buffer;
    }

    public function getGlobalScriptTask(string $id): GlobalScriptTask
    {
        /** @var GlobalScriptTask $buffer */
        $buffer = $this->get('GlobalScriptTask', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalTask> */
    public function findAllGlobalTask(): ElementList
    {
        /** @var ElementList<GlobalTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalTask'));

        return $buffer;
    }

    public function findGlobalTask(string $id): ?GlobalTask
    {
        /** @var GlobalTask|null $buffer */
        $buffer = $this->find('GlobalTask', $id);

        return $buffer;
    }

    public function getGlobalTask(string $id): GlobalTask
    {
        /** @var GlobalTask $buffer */
        $buffer = $this->get('GlobalTask', $id);

        return $buffer;
    }

    /** @return ElementList<GlobalUserTask> */
    public function findAllGlobalUserTask(): ElementList
    {
        /** @var ElementList<GlobalUserTask> $buffer */
        $buffer = $this->findAll(lcfirst('GlobalUserTask'));

        return $buffer;
    }

    public function findGlobalUserTask(string $id): ?GlobalUserTask
    {
        /** @var GlobalUserTask|null $buffer */
        $buffer = $this->find('GlobalUserTask', $id);

        return $buffer;
    }

    public function getGlobalUserTask(string $id): GlobalUserTask
    {
        /** @var GlobalUserTask $buffer */
        $buffer = $this->get('GlobalUserTask', $id);

        return $buffer;
    }

    /** @return ElementList<Group> */
    public function findAllGroup(): ElementList
    {
        /** @var ElementList<Group> $buffer */
        $buffer = $this->findAll(lcfirst('Group'));

        return $buffer;
    }

    public function findGroup(string $id): ?Group
    {
        /** @var Group|null $buffer */
        $buffer = $this->find('Group', $id);

        return $buffer;
    }

    public function getGroup(string $id): Group
    {
        /** @var Group $buffer */
        $buffer = $this->get('Group', $id);

        return $buffer;
    }

    /** @return ElementList<HumanPerformer> */
    public function findAllHumanPerformer(): ElementList
    {
        /** @var ElementList<HumanPerformer> $buffer */
        $buffer = $this->findAll(lcfirst('HumanPerformer'));

        return $buffer;
    }

    public function findHumanPerformer(string $id): ?HumanPerformer
    {
        /** @var HumanPerformer|null $buffer */
        $buffer = $this->find('HumanPerformer', $id);

        return $buffer;
    }

    public function getHumanPerformer(string $id): HumanPerformer
    {
        /** @var HumanPerformer $buffer */
        $buffer = $this->get('HumanPerformer', $id);

        return $buffer;
    }

    /** @return ElementList<ImplicitThrowEvent> */
    public function findAllImplicitThrowEvent(): ElementList
    {
        /** @var ElementList<ImplicitThrowEvent> $buffer */
        $buffer = $this->findAll(lcfirst('ImplicitThrowEvent'));

        return $buffer;
    }

    public function findImplicitThrowEvent(string $id): ?ImplicitThrowEvent
    {
        /** @var ImplicitThrowEvent|null $buffer */
        $buffer = $this->find('ImplicitThrowEvent', $id);

        return $buffer;
    }

    public function getImplicitThrowEvent(string $id): ImplicitThrowEvent
    {
        /** @var ImplicitThrowEvent $buffer */
        $buffer = $this->get('ImplicitThrowEvent', $id);

        return $buffer;
    }

    /** @return ElementList<InclusiveGateway> */
    public function findAllInclusiveGateway(): ElementList
    {
        /** @var ElementList<InclusiveGateway> $buffer */
        $buffer = $this->findAll(lcfirst('InclusiveGateway'));

        return $buffer;
    }

    public function findInclusiveGateway(string $id): ?InclusiveGateway
    {
        /** @var InclusiveGateway|null $buffer */
        $buffer = $this->find('InclusiveGateway', $id);

        return $buffer;
    }

    public function getInclusiveGateway(string $id): InclusiveGateway
    {
        /** @var InclusiveGateway $buffer */
        $buffer = $this->get('InclusiveGateway', $id);

        return $buffer;
    }

    /** @return ElementList<InputSet> */
    public function findAllInputSet(): ElementList
    {
        /** @var ElementList<InputSet> $buffer */
        $buffer = $this->findAll(lcfirst('InputSet'));

        return $buffer;
    }

    public function findInputSet(string $id): ?InputSet
    {
        /** @var InputSet|null $buffer */
        $buffer = $this->find('InputSet', $id);

        return $buffer;
    }

    public function getInputSet(string $id): InputSet
    {
        /** @var InputSet $buffer */
        $buffer = $this->get('InputSet', $id);

        return $buffer;
    }

    /** @return ElementList<InterfaceElement> */
    public function findAllInterfaceElement(): ElementList
    {
        /** @var ElementList<InterfaceElement> $buffer */
        $buffer = $this->findAll(lcfirst('InterfaceElement'));

        return $buffer;
    }

    public function findInterfaceElement(string $id): ?InterfaceElement
    {
        /** @var InterfaceElement|null $buffer */
        $buffer = $this->find('InterfaceElement', $id);

        return $buffer;
    }

    public function getInterfaceElement(string $id): InterfaceElement
    {
        /** @var InterfaceElement $buffer */
        $buffer = $this->get('InterfaceElement', $id);

        return $buffer;
    }

    /** @return ElementList<IntermediateCatchEvent> */
    public function findAllIntermediateCatchEvent(): ElementList
    {
        /** @var ElementList<IntermediateCatchEvent> $buffer */
        $buffer = $this->findAll(lcfirst('IntermediateCatchEvent'));

        return $buffer;
    }

    public function findIntermediateCatchEvent(string $id): ?IntermediateCatchEvent
    {
        /** @var IntermediateCatchEvent|null $buffer */
        $buffer = $this->find('IntermediateCatchEvent', $id);

        return $buffer;
    }

    public function getIntermediateCatchEvent(string $id): IntermediateCatchEvent
    {
        /** @var IntermediateCatchEvent $buffer */
        $buffer = $this->get('IntermediateCatchEvent', $id);

        return $buffer;
    }

    /** @return ElementList<IntermediateThrowEvent> */
    public function findAllIntermediateThrowEvent(): ElementList
    {
        /** @var ElementList<IntermediateThrowEvent> $buffer */
        $buffer = $this->findAll(lcfirst('IntermediateThrowEvent'));

        return $buffer;
    }

    public function findIntermediateThrowEvent(string $id): ?IntermediateThrowEvent
    {
        /** @var IntermediateThrowEvent|null $buffer */
        $buffer = $this->find('IntermediateThrowEvent', $id);

        return $buffer;
    }

    public function getIntermediateThrowEvent(string $id): IntermediateThrowEvent
    {
        /** @var IntermediateThrowEvent $buffer */
        $buffer = $this->get('IntermediateThrowEvent', $id);

        return $buffer;
    }

    /** @return ElementList<IoBinding> */
    public function findAllIoBinding(): ElementList
    {
        /** @var ElementList<IoBinding> $buffer */
        $buffer = $this->findAll(lcfirst('IoBinding'));

        return $buffer;
    }

    public function findIoBinding(string $id): ?IoBinding
    {
        /** @var IoBinding|null $buffer */
        $buffer = $this->find('IoBinding', $id);

        return $buffer;
    }

    public function getIoBinding(string $id): IoBinding
    {
        /** @var IoBinding $buffer */
        $buffer = $this->get('IoBinding', $id);

        return $buffer;
    }

    /** @return ElementList<IoSpecification> */
    public function findAllIoSpecification(): ElementList
    {
        /** @var ElementList<IoSpecification> $buffer */
        $buffer = $this->findAll(lcfirst('IoSpecification'));

        return $buffer;
    }

    public function findIoSpecification(string $id): ?IoSpecification
    {
        /** @var IoSpecification|null $buffer */
        $buffer = $this->find('IoSpecification', $id);

        return $buffer;
    }

    public function getIoSpecification(string $id): IoSpecification
    {
        /** @var IoSpecification $buffer */
        $buffer = $this->get('IoSpecification', $id);

        return $buffer;
    }

    /** @return ElementList<ItemDefinition> */
    public function findAllItemDefinition(): ElementList
    {
        /** @var ElementList<ItemDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('ItemDefinition'));

        return $buffer;
    }

    public function findItemDefinition(string $id): ?ItemDefinition
    {
        /** @var ItemDefinition|null $buffer */
        $buffer = $this->find('ItemDefinition', $id);

        return $buffer;
    }

    public function getItemDefinition(string $id): ItemDefinition
    {
        /** @var ItemDefinition $buffer */
        $buffer = $this->get('ItemDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<Lane> */
    public function findAllLane(): ElementList
    {
        /** @var ElementList<Lane> $buffer */
        $buffer = $this->findAll(lcfirst('Lane'));

        return $buffer;
    }

    public function findLane(string $id): ?Lane
    {
        /** @var Lane|null $buffer */
        $buffer = $this->find('Lane', $id);

        return $buffer;
    }

    public function getLane(string $id): Lane
    {
        /** @var Lane $buffer */
        $buffer = $this->get('Lane', $id);

        return $buffer;
    }

    /** @return ElementList<LaneSet> */
    public function findAllLaneSet(): ElementList
    {
        /** @var ElementList<LaneSet> $buffer */
        $buffer = $this->findAll(lcfirst('LaneSet'));

        return $buffer;
    }

    public function findLaneSet(string $id): ?LaneSet
    {
        /** @var LaneSet|null $buffer */
        $buffer = $this->find('LaneSet', $id);

        return $buffer;
    }

    public function getLaneSet(string $id): LaneSet
    {
        /** @var LaneSet $buffer */
        $buffer = $this->get('LaneSet', $id);

        return $buffer;
    }

    /** @return ElementList<LinkEventDefinition> */
    public function findAllLinkEventDefinition(): ElementList
    {
        /** @var ElementList<LinkEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('LinkEventDefinition'));

        return $buffer;
    }

    public function findLinkEventDefinition(string $id): ?LinkEventDefinition
    {
        /** @var LinkEventDefinition|null $buffer */
        $buffer = $this->find('LinkEventDefinition', $id);

        return $buffer;
    }

    public function getLinkEventDefinition(string $id): LinkEventDefinition
    {
        /** @var LinkEventDefinition $buffer */
        $buffer = $this->get('LinkEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<LoopCharacteristics> */
    public function findAllLoopCharacteristics(): ElementList
    {
        /** @var ElementList<LoopCharacteristics> $buffer */
        $buffer = $this->findAll(lcfirst('LoopCharacteristics'));

        return $buffer;
    }

    public function findLoopCharacteristics(string $id): ?LoopCharacteristics
    {
        /** @var LoopCharacteristics|null $buffer */
        $buffer = $this->find('LoopCharacteristics', $id);

        return $buffer;
    }

    public function getLoopCharacteristics(string $id): LoopCharacteristics
    {
        /** @var LoopCharacteristics $buffer */
        $buffer = $this->get('LoopCharacteristics', $id);

        return $buffer;
    }

    /** @return ElementList<ManualTask> */
    public function findAllManualTask(): ElementList
    {
        /** @var ElementList<ManualTask> $buffer */
        $buffer = $this->findAll(lcfirst('ManualTask'));

        return $buffer;
    }

    public function findManualTask(string $id): ?ManualTask
    {
        /** @var ManualTask|null $buffer */
        $buffer = $this->find('ManualTask', $id);

        return $buffer;
    }

    public function getManualTask(string $id): ManualTask
    {
        /** @var ManualTask $buffer */
        $buffer = $this->get('ManualTask', $id);

        return $buffer;
    }

    /** @return ElementList<Message> */
    public function findAllMessage(): ElementList
    {
        /** @var ElementList<Message> $buffer */
        $buffer = $this->findAll(lcfirst('Message'));

        return $buffer;
    }

    public function findMessage(string $id): ?Message
    {
        /** @var Message|null $buffer */
        $buffer = $this->find('Message', $id);

        return $buffer;
    }

    public function getMessage(string $id): Message
    {
        /** @var Message $buffer */
        $buffer = $this->get('Message', $id);

        return $buffer;
    }

    /** @return ElementList<MessageEventDefinition> */
    public function findAllMessageEventDefinition(): ElementList
    {
        /** @var ElementList<MessageEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('MessageEventDefinition'));

        return $buffer;
    }

    public function findMessageEventDefinition(string $id): ?MessageEventDefinition
    {
        /** @var MessageEventDefinition|null $buffer */
        $buffer = $this->find('MessageEventDefinition', $id);

        return $buffer;
    }

    public function getMessageEventDefinition(string $id): MessageEventDefinition
    {
        /** @var MessageEventDefinition $buffer */
        $buffer = $this->get('MessageEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<MessageFlow> */
    public function findAllMessageFlow(): ElementList
    {
        /** @var ElementList<MessageFlow> $buffer */
        $buffer = $this->findAll(lcfirst('MessageFlow'));

        return $buffer;
    }

    public function findMessageFlow(string $id): ?MessageFlow
    {
        /** @var MessageFlow|null $buffer */
        $buffer = $this->find('MessageFlow', $id);

        return $buffer;
    }

    public function getMessageFlow(string $id): MessageFlow
    {
        /** @var MessageFlow $buffer */
        $buffer = $this->get('MessageFlow', $id);

        return $buffer;
    }

    /** @return ElementList<MessageFlowAssociation> */
    public function findAllMessageFlowAssociation(): ElementList
    {
        /** @var ElementList<MessageFlowAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('MessageFlowAssociation'));

        return $buffer;
    }

    public function findMessageFlowAssociation(string $id): ?MessageFlowAssociation
    {
        /** @var MessageFlowAssociation|null $buffer */
        $buffer = $this->find('MessageFlowAssociation', $id);

        return $buffer;
    }

    public function getMessageFlowAssociation(string $id): MessageFlowAssociation
    {
        /** @var MessageFlowAssociation $buffer */
        $buffer = $this->get('MessageFlowAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<Monitoring> */
    public function findAllMonitoring(): ElementList
    {
        /** @var ElementList<Monitoring> $buffer */
        $buffer = $this->findAll(lcfirst('Monitoring'));

        return $buffer;
    }

    public function findMonitoring(string $id): ?Monitoring
    {
        /** @var Monitoring|null $buffer */
        $buffer = $this->find('Monitoring', $id);

        return $buffer;
    }

    public function getMonitoring(string $id): Monitoring
    {
        /** @var Monitoring $buffer */
        $buffer = $this->get('Monitoring', $id);

        return $buffer;
    }

    /** @return ElementList<MultiInstanceLoopCharacteristics> */
    public function findAllMultiInstanceLoopCharacteristics(): ElementList
    {
        /** @var ElementList<MultiInstanceLoopCharacteristics> $buffer */
        $buffer = $this->findAll(lcfirst('MultiInstanceLoopCharacteristics'));

        return $buffer;
    }

    public function findMultiInstanceLoopCharacteristics(string $id): ?MultiInstanceLoopCharacteristics
    {
        /** @var MultiInstanceLoopCharacteristics|null $buffer */
        $buffer = $this->find('MultiInstanceLoopCharacteristics', $id);

        return $buffer;
    }

    public function getMultiInstanceLoopCharacteristics(string $id): MultiInstanceLoopCharacteristics
    {
        /** @var MultiInstanceLoopCharacteristics $buffer */
        $buffer = $this->get('MultiInstanceLoopCharacteristics', $id);

        return $buffer;
    }

    /** @return ElementList<Operation> */
    public function findAllOperation(): ElementList
    {
        /** @var ElementList<Operation> $buffer */
        $buffer = $this->findAll(lcfirst('Operation'));

        return $buffer;
    }

    public function findOperation(string $id): ?Operation
    {
        /** @var Operation|null $buffer */
        $buffer = $this->find('Operation', $id);

        return $buffer;
    }

    public function getOperation(string $id): Operation
    {
        /** @var Operation $buffer */
        $buffer = $this->get('Operation', $id);

        return $buffer;
    }

    /** @return ElementList<OutputSet> */
    public function findAllOutputSet(): ElementList
    {
        /** @var ElementList<OutputSet> $buffer */
        $buffer = $this->findAll(lcfirst('OutputSet'));

        return $buffer;
    }

    public function findOutputSet(string $id): ?OutputSet
    {
        /** @var OutputSet|null $buffer */
        $buffer = $this->find('OutputSet', $id);

        return $buffer;
    }

    public function getOutputSet(string $id): OutputSet
    {
        /** @var OutputSet $buffer */
        $buffer = $this->get('OutputSet', $id);

        return $buffer;
    }

    /** @return ElementList<ParallelGateway> */
    public function findAllParallelGateway(): ElementList
    {
        /** @var ElementList<ParallelGateway> $buffer */
        $buffer = $this->findAll(lcfirst('ParallelGateway'));

        return $buffer;
    }

    public function findParallelGateway(string $id): ?ParallelGateway
    {
        /** @var ParallelGateway|null $buffer */
        $buffer = $this->find('ParallelGateway', $id);

        return $buffer;
    }

    public function getParallelGateway(string $id): ParallelGateway
    {
        /** @var ParallelGateway $buffer */
        $buffer = $this->get('ParallelGateway', $id);

        return $buffer;
    }

    /** @return ElementList<Participant> */
    public function findAllParticipant(): ElementList
    {
        /** @var ElementList<Participant> $buffer */
        $buffer = $this->findAll(lcfirst('Participant'));

        return $buffer;
    }

    public function findParticipant(string $id): ?Participant
    {
        /** @var Participant|null $buffer */
        $buffer = $this->find('Participant', $id);

        return $buffer;
    }

    public function getParticipant(string $id): Participant
    {
        /** @var Participant $buffer */
        $buffer = $this->get('Participant', $id);

        return $buffer;
    }

    /** @return ElementList<ParticipantAssociation> */
    public function findAllParticipantAssociation(): ElementList
    {
        /** @var ElementList<ParticipantAssociation> $buffer */
        $buffer = $this->findAll(lcfirst('ParticipantAssociation'));

        return $buffer;
    }

    public function findParticipantAssociation(string $id): ?ParticipantAssociation
    {
        /** @var ParticipantAssociation|null $buffer */
        $buffer = $this->find('ParticipantAssociation', $id);

        return $buffer;
    }

    public function getParticipantAssociation(string $id): ParticipantAssociation
    {
        /** @var ParticipantAssociation $buffer */
        $buffer = $this->get('ParticipantAssociation', $id);

        return $buffer;
    }

    /** @return ElementList<ParticipantMultiplicity> */
    public function findAllParticipantMultiplicity(): ElementList
    {
        /** @var ElementList<ParticipantMultiplicity> $buffer */
        $buffer = $this->findAll(lcfirst('ParticipantMultiplicity'));

        return $buffer;
    }

    public function findParticipantMultiplicity(string $id): ?ParticipantMultiplicity
    {
        /** @var ParticipantMultiplicity|null $buffer */
        $buffer = $this->find('ParticipantMultiplicity', $id);

        return $buffer;
    }

    public function getParticipantMultiplicity(string $id): ParticipantMultiplicity
    {
        /** @var ParticipantMultiplicity $buffer */
        $buffer = $this->get('ParticipantMultiplicity', $id);

        return $buffer;
    }

    /** @return ElementList<PartnerEntity> */
    public function findAllPartnerEntity(): ElementList
    {
        /** @var ElementList<PartnerEntity> $buffer */
        $buffer = $this->findAll(lcfirst('PartnerEntity'));

        return $buffer;
    }

    public function findPartnerEntity(string $id): ?PartnerEntity
    {
        /** @var PartnerEntity|null $buffer */
        $buffer = $this->find('PartnerEntity', $id);

        return $buffer;
    }

    public function getPartnerEntity(string $id): PartnerEntity
    {
        /** @var PartnerEntity $buffer */
        $buffer = $this->get('PartnerEntity', $id);

        return $buffer;
    }

    /** @return ElementList<PartnerRole> */
    public function findAllPartnerRole(): ElementList
    {
        /** @var ElementList<PartnerRole> $buffer */
        $buffer = $this->findAll(lcfirst('PartnerRole'));

        return $buffer;
    }

    public function findPartnerRole(string $id): ?PartnerRole
    {
        /** @var PartnerRole|null $buffer */
        $buffer = $this->find('PartnerRole', $id);

        return $buffer;
    }

    public function getPartnerRole(string $id): PartnerRole
    {
        /** @var PartnerRole $buffer */
        $buffer = $this->get('PartnerRole', $id);

        return $buffer;
    }

    /** @return ElementList<Performer> */
    public function findAllPerformer(): ElementList
    {
        /** @var ElementList<Performer> $buffer */
        $buffer = $this->findAll(lcfirst('Performer'));

        return $buffer;
    }

    public function findPerformer(string $id): ?Performer
    {
        /** @var Performer|null $buffer */
        $buffer = $this->find('Performer', $id);

        return $buffer;
    }

    public function getPerformer(string $id): Performer
    {
        /** @var Performer $buffer */
        $buffer = $this->get('Performer', $id);

        return $buffer;
    }

    /** @return ElementList<PotentialOwner> */
    public function findAllPotentialOwner(): ElementList
    {
        /** @var ElementList<PotentialOwner> $buffer */
        $buffer = $this->findAll(lcfirst('PotentialOwner'));

        return $buffer;
    }

    public function findPotentialOwner(string $id): ?PotentialOwner
    {
        /** @var PotentialOwner|null $buffer */
        $buffer = $this->find('PotentialOwner', $id);

        return $buffer;
    }

    public function getPotentialOwner(string $id): PotentialOwner
    {
        /** @var PotentialOwner $buffer */
        $buffer = $this->get('PotentialOwner', $id);

        return $buffer;
    }

    /** @return ElementList<Process> */
    public function findAllProcess(): ElementList
    {
        /** @var ElementList<Process> $buffer */
        $buffer = $this->findAll(lcfirst('Process'));

        return $buffer;
    }

    public function findProcess(string $id): ?Process
    {
        /** @var Process|null $buffer */
        $buffer = $this->find('Process', $id);

        return $buffer;
    }

    public function getProcess(string $id): Process
    {
        /** @var Process $buffer */
        $buffer = $this->get('Process', $id);

        return $buffer;
    }

    /** @return ElementList<Property> */
    public function findAllProperty(): ElementList
    {
        /** @var ElementList<Property> $buffer */
        $buffer = $this->findAll(lcfirst('Property'));

        return $buffer;
    }

    public function findProperty(string $id): ?Property
    {
        /** @var Property|null $buffer */
        $buffer = $this->find('Property', $id);

        return $buffer;
    }

    public function getProperty(string $id): Property
    {
        /** @var Property $buffer */
        $buffer = $this->get('Property', $id);

        return $buffer;
    }

    /** @return ElementList<ReceiveTask> */
    public function findAllReceiveTask(): ElementList
    {
        /** @var ElementList<ReceiveTask> $buffer */
        $buffer = $this->findAll(lcfirst('ReceiveTask'));

        return $buffer;
    }

    public function findReceiveTask(string $id): ?ReceiveTask
    {
        /** @var ReceiveTask|null $buffer */
        $buffer = $this->find('ReceiveTask', $id);

        return $buffer;
    }

    public function getReceiveTask(string $id): ReceiveTask
    {
        /** @var ReceiveTask $buffer */
        $buffer = $this->get('ReceiveTask', $id);

        return $buffer;
    }

    /** @return ElementList<Relationship> */
    public function findAllRelationship(): ElementList
    {
        /** @var ElementList<Relationship> $buffer */
        $buffer = $this->findAll(lcfirst('Relationship'));

        return $buffer;
    }

    public function findRelationship(string $id): ?Relationship
    {
        /** @var Relationship|null $buffer */
        $buffer = $this->find('Relationship', $id);

        return $buffer;
    }

    public function getRelationship(string $id): Relationship
    {
        /** @var Relationship $buffer */
        $buffer = $this->get('Relationship', $id);

        return $buffer;
    }

    /** @return ElementList<Rendering> */
    public function findAllRendering(): ElementList
    {
        /** @var ElementList<Rendering> $buffer */
        $buffer = $this->findAll(lcfirst('Rendering'));

        return $buffer;
    }

    public function findRendering(string $id): ?Rendering
    {
        /** @var Rendering|null $buffer */
        $buffer = $this->find('Rendering', $id);

        return $buffer;
    }

    public function getRendering(string $id): Rendering
    {
        /** @var Rendering $buffer */
        $buffer = $this->get('Rendering', $id);

        return $buffer;
    }

    /** @return ElementList<Resource> */
    public function findAllResource(): ElementList
    {
        /** @var ElementList<Resource> $buffer */
        $buffer = $this->findAll(lcfirst('Resource'));

        return $buffer;
    }

    public function findResource(string $id): ?Resource
    {
        /** @var Resource|null $buffer */
        $buffer = $this->find('Resource', $id);

        return $buffer;
    }

    public function getResource(string $id): Resource
    {
        /** @var Resource $buffer */
        $buffer = $this->get('Resource', $id);

        return $buffer;
    }

    /** @return ElementList<ResourceAssignmentExpression> */
    public function findAllResourceAssignmentExpression(): ElementList
    {
        /** @var ElementList<ResourceAssignmentExpression> $buffer */
        $buffer = $this->findAll(lcfirst('ResourceAssignmentExpression'));

        return $buffer;
    }

    public function findResourceAssignmentExpression(string $id): ?ResourceAssignmentExpression
    {
        /** @var ResourceAssignmentExpression|null $buffer */
        $buffer = $this->find('ResourceAssignmentExpression', $id);

        return $buffer;
    }

    public function getResourceAssignmentExpression(string $id): ResourceAssignmentExpression
    {
        /** @var ResourceAssignmentExpression $buffer */
        $buffer = $this->get('ResourceAssignmentExpression', $id);

        return $buffer;
    }

    /** @return ElementList<ResourceParameter> */
    public function findAllResourceParameter(): ElementList
    {
        /** @var ElementList<ResourceParameter> $buffer */
        $buffer = $this->findAll(lcfirst('ResourceParameter'));

        return $buffer;
    }

    public function findResourceParameter(string $id): ?ResourceParameter
    {
        /** @var ResourceParameter|null $buffer */
        $buffer = $this->find('ResourceParameter', $id);

        return $buffer;
    }

    public function getResourceParameter(string $id): ResourceParameter
    {
        /** @var ResourceParameter $buffer */
        $buffer = $this->get('ResourceParameter', $id);

        return $buffer;
    }

    /** @return ElementList<ResourceParameterBinding> */
    public function findAllResourceParameterBinding(): ElementList
    {
        /** @var ElementList<ResourceParameterBinding> $buffer */
        $buffer = $this->findAll(lcfirst('ResourceParameterBinding'));

        return $buffer;
    }

    public function findResourceParameterBinding(string $id): ?ResourceParameterBinding
    {
        /** @var ResourceParameterBinding|null $buffer */
        $buffer = $this->find('ResourceParameterBinding', $id);

        return $buffer;
    }

    public function getResourceParameterBinding(string $id): ResourceParameterBinding
    {
        /** @var ResourceParameterBinding $buffer */
        $buffer = $this->get('ResourceParameterBinding', $id);

        return $buffer;
    }

    /** @return ElementList<ResourceRole> */
    public function findAllResourceRole(): ElementList
    {
        /** @var ElementList<ResourceRole> $buffer */
        $buffer = $this->findAll(lcfirst('ResourceRole'));

        return $buffer;
    }

    public function findResourceRole(string $id): ?ResourceRole
    {
        /** @var ResourceRole|null $buffer */
        $buffer = $this->find('ResourceRole', $id);

        return $buffer;
    }

    public function getResourceRole(string $id): ResourceRole
    {
        /** @var ResourceRole $buffer */
        $buffer = $this->get('ResourceRole', $id);

        return $buffer;
    }

    /** @return ElementList<RootElement> */
    public function findAllRootElement(): ElementList
    {
        /** @var ElementList<RootElement> $buffer */
        $buffer = $this->findAll(lcfirst('RootElement'));

        return $buffer;
    }

    public function findRootElement(string $id): ?RootElement
    {
        /** @var RootElement|null $buffer */
        $buffer = $this->find('RootElement', $id);

        return $buffer;
    }

    public function getRootElement(string $id): RootElement
    {
        /** @var RootElement $buffer */
        $buffer = $this->get('RootElement', $id);

        return $buffer;
    }

    /** @return ElementList<ScriptTask> */
    public function findAllScriptTask(): ElementList
    {
        /** @var ElementList<ScriptTask> $buffer */
        $buffer = $this->findAll(lcfirst('ScriptTask'));

        return $buffer;
    }

    public function findScriptTask(string $id): ?ScriptTask
    {
        /** @var ScriptTask|null $buffer */
        $buffer = $this->find('ScriptTask', $id);

        return $buffer;
    }

    public function getScriptTask(string $id): ScriptTask
    {
        /** @var ScriptTask $buffer */
        $buffer = $this->get('ScriptTask', $id);

        return $buffer;
    }

    /** @return ElementList<Script> */
    public function findAllScript(): ElementList
    {
        /** @var ElementList<Script> $buffer */
        $buffer = $this->findAll(lcfirst('Script'));

        return $buffer;
    }

    public function findScript(string $id): ?Script
    {
        /** @var Script|null $buffer */
        $buffer = $this->find('Script', $id);

        return $buffer;
    }

    public function getScript(string $id): Script
    {
        /** @var Script $buffer */
        $buffer = $this->get('Script', $id);

        return $buffer;
    }

    /** @return ElementList<SendTask> */
    public function findAllSendTask(): ElementList
    {
        /** @var ElementList<SendTask> $buffer */
        $buffer = $this->findAll(lcfirst('SendTask'));

        return $buffer;
    }

    public function findSendTask(string $id): ?SendTask
    {
        /** @var SendTask|null $buffer */
        $buffer = $this->find('SendTask', $id);

        return $buffer;
    }

    public function getSendTask(string $id): SendTask
    {
        /** @var SendTask $buffer */
        $buffer = $this->get('SendTask', $id);

        return $buffer;
    }

    /** @return ElementList<SequenceFlow> */
    public function findAllSequenceFlow(): ElementList
    {
        /** @var ElementList<SequenceFlow> $buffer */
        $buffer = $this->findAll(lcfirst('SequenceFlow'));

        return $buffer;
    }

    public function findSequenceFlow(string $id): ?SequenceFlow
    {
        /** @var SequenceFlow|null $buffer */
        $buffer = $this->find('SequenceFlow', $id);

        return $buffer;
    }

    public function getSequenceFlow(string $id): SequenceFlow
    {
        /** @var SequenceFlow $buffer */
        $buffer = $this->get('SequenceFlow', $id);

        return $buffer;
    }

    /** @return ElementList<ServiceTask> */
    public function findAllServiceTask(): ElementList
    {
        /** @var ElementList<ServiceTask> $buffer */
        $buffer = $this->findAll(lcfirst('ServiceTask'));

        return $buffer;
    }

    public function findServiceTask(string $id): ?ServiceTask
    {
        /** @var ServiceTask|null $buffer */
        $buffer = $this->find('ServiceTask', $id);

        return $buffer;
    }

    public function getServiceTask(string $id): ServiceTask
    {
        /** @var ServiceTask $buffer */
        $buffer = $this->get('ServiceTask', $id);

        return $buffer;
    }

    /** @return ElementList<Signal> */
    public function findAllSignal(): ElementList
    {
        /** @var ElementList<Signal> $buffer */
        $buffer = $this->findAll(lcfirst('Signal'));

        return $buffer;
    }

    public function findSignal(string $id): ?Signal
    {
        /** @var Signal|null $buffer */
        $buffer = $this->find('Signal', $id);

        return $buffer;
    }

    public function getSignal(string $id): Signal
    {
        /** @var Signal $buffer */
        $buffer = $this->get('Signal', $id);

        return $buffer;
    }

    /** @return ElementList<SignalEventDefinition> */
    public function findAllSignalEventDefinition(): ElementList
    {
        /** @var ElementList<SignalEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('SignalEventDefinition'));

        return $buffer;
    }

    public function findSignalEventDefinition(string $id): ?SignalEventDefinition
    {
        /** @var SignalEventDefinition|null $buffer */
        $buffer = $this->find('SignalEventDefinition', $id);

        return $buffer;
    }

    public function getSignalEventDefinition(string $id): SignalEventDefinition
    {
        /** @var SignalEventDefinition $buffer */
        $buffer = $this->get('SignalEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<StandardLoopCharacteristics> */
    public function findAllStandardLoopCharacteristics(): ElementList
    {
        /** @var ElementList<StandardLoopCharacteristics> $buffer */
        $buffer = $this->findAll(lcfirst('StandardLoopCharacteristics'));

        return $buffer;
    }

    public function findStandardLoopCharacteristics(string $id): ?StandardLoopCharacteristics
    {
        /** @var StandardLoopCharacteristics|null $buffer */
        $buffer = $this->find('StandardLoopCharacteristics', $id);

        return $buffer;
    }

    public function getStandardLoopCharacteristics(string $id): StandardLoopCharacteristics
    {
        /** @var StandardLoopCharacteristics $buffer */
        $buffer = $this->get('StandardLoopCharacteristics', $id);

        return $buffer;
    }

    /** @return ElementList<StartEvent> */
    public function findAllStartEvent(): ElementList
    {
        /** @var ElementList<StartEvent> $buffer */
        $buffer = $this->findAll(lcfirst('StartEvent'));

        return $buffer;
    }

    public function findStartEvent(string $id): ?StartEvent
    {
        /** @var StartEvent|null $buffer */
        $buffer = $this->find('StartEvent', $id);

        return $buffer;
    }

    public function getStartEvent(string $id): StartEvent
    {
        /** @var StartEvent $buffer */
        $buffer = $this->get('StartEvent', $id);

        return $buffer;
    }

    /** @return ElementList<SubChoreography> */
    public function findAllSubChoreography(): ElementList
    {
        /** @var ElementList<SubChoreography> $buffer */
        $buffer = $this->findAll(lcfirst('SubChoreography'));

        return $buffer;
    }

    public function findSubChoreography(string $id): ?SubChoreography
    {
        /** @var SubChoreography|null $buffer */
        $buffer = $this->find('SubChoreography', $id);

        return $buffer;
    }

    public function getSubChoreography(string $id): SubChoreography
    {
        /** @var SubChoreography $buffer */
        $buffer = $this->get('SubChoreography', $id);

        return $buffer;
    }

    /** @return ElementList<SubConversation> */
    public function findAllSubConversation(): ElementList
    {
        /** @var ElementList<SubConversation> $buffer */
        $buffer = $this->findAll(lcfirst('SubConversation'));

        return $buffer;
    }

    public function findSubConversation(string $id): ?SubConversation
    {
        /** @var SubConversation|null $buffer */
        $buffer = $this->find('SubConversation', $id);

        return $buffer;
    }

    public function getSubConversation(string $id): SubConversation
    {
        /** @var SubConversation $buffer */
        $buffer = $this->get('SubConversation', $id);

        return $buffer;
    }

    /** @return ElementList<SubProcess> */
    public function findAllSubProcess(): ElementList
    {
        /** @var ElementList<SubProcess> $buffer */
        $buffer = $this->findAll(lcfirst('SubProcess'));

        return $buffer;
    }

    public function findSubProcess(string $id): ?SubProcess
    {
        /** @var SubProcess|null $buffer */
        $buffer = $this->find('SubProcess', $id);

        return $buffer;
    }

    public function getSubProcess(string $id): SubProcess
    {
        /** @var SubProcess $buffer */
        $buffer = $this->get('SubProcess', $id);

        return $buffer;
    }

    /** @return ElementList<Task> */
    public function findAllTask(): ElementList
    {
        /** @var ElementList<Task> $buffer */
        $buffer = $this->findAll(lcfirst('Task'));

        return $buffer;
    }

    public function findTask(string $id): ?Task
    {
        /** @var Task|null $buffer */
        $buffer = $this->find('Task', $id);

        return $buffer;
    }

    public function getTask(string $id): Task
    {
        /** @var Task $buffer */
        $buffer = $this->get('Task', $id);

        return $buffer;
    }

    /** @return ElementList<TerminateEventDefinition> */
    public function findAllTerminateEventDefinition(): ElementList
    {
        /** @var ElementList<TerminateEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('TerminateEventDefinition'));

        return $buffer;
    }

    public function findTerminateEventDefinition(string $id): ?TerminateEventDefinition
    {
        /** @var TerminateEventDefinition|null $buffer */
        $buffer = $this->find('TerminateEventDefinition', $id);

        return $buffer;
    }

    public function getTerminateEventDefinition(string $id): TerminateEventDefinition
    {
        /** @var TerminateEventDefinition $buffer */
        $buffer = $this->get('TerminateEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<TextAnnotation> */
    public function findAllTextAnnotation(): ElementList
    {
        /** @var ElementList<TextAnnotation> $buffer */
        $buffer = $this->findAll(lcfirst('TextAnnotation'));

        return $buffer;
    }

    public function findTextAnnotation(string $id): ?TextAnnotation
    {
        /** @var TextAnnotation|null $buffer */
        $buffer = $this->find('TextAnnotation', $id);

        return $buffer;
    }

    public function getTextAnnotation(string $id): TextAnnotation
    {
        /** @var TextAnnotation $buffer */
        $buffer = $this->get('TextAnnotation', $id);

        return $buffer;
    }

    /** @return ElementList<Text> */
    public function findAllText(): ElementList
    {
        /** @var ElementList<Text> $buffer */
        $buffer = $this->findAll(lcfirst('Text'));

        return $buffer;
    }

    public function findText(string $id): ?Text
    {
        /** @var Text|null $buffer */
        $buffer = $this->find('Text', $id);

        return $buffer;
    }

    public function getText(string $id): Text
    {
        /** @var Text $buffer */
        $buffer = $this->get('Text', $id);

        return $buffer;
    }

    /** @return ElementList<ThrowEvent> */
    public function findAllThrowEvent(): ElementList
    {
        /** @var ElementList<ThrowEvent> $buffer */
        $buffer = $this->findAll(lcfirst('ThrowEvent'));

        return $buffer;
    }

    public function findThrowEvent(string $id): ?ThrowEvent
    {
        /** @var ThrowEvent|null $buffer */
        $buffer = $this->find('ThrowEvent', $id);

        return $buffer;
    }

    public function getThrowEvent(string $id): ThrowEvent
    {
        /** @var ThrowEvent $buffer */
        $buffer = $this->get('ThrowEvent', $id);

        return $buffer;
    }

    /** @return ElementList<TimerEventDefinition> */
    public function findAllTimerEventDefinition(): ElementList
    {
        /** @var ElementList<TimerEventDefinition> $buffer */
        $buffer = $this->findAll(lcfirst('TimerEventDefinition'));

        return $buffer;
    }

    public function findTimerEventDefinition(string $id): ?TimerEventDefinition
    {
        /** @var TimerEventDefinition|null $buffer */
        $buffer = $this->find('TimerEventDefinition', $id);

        return $buffer;
    }

    public function getTimerEventDefinition(string $id): TimerEventDefinition
    {
        /** @var TimerEventDefinition $buffer */
        $buffer = $this->get('TimerEventDefinition', $id);

        return $buffer;
    }

    /** @return ElementList<Transaction> */
    public function findAllTransaction(): ElementList
    {
        /** @var ElementList<Transaction> $buffer */
        $buffer = $this->findAll(lcfirst('Transaction'));

        return $buffer;
    }

    public function findTransaction(string $id): ?Transaction
    {
        /** @var Transaction|null $buffer */
        $buffer = $this->find('Transaction', $id);

        return $buffer;
    }

    public function getTransaction(string $id): Transaction
    {
        /** @var Transaction $buffer */
        $buffer = $this->get('Transaction', $id);

        return $buffer;
    }

    /** @return ElementList<UserTask> */
    public function findAllUserTask(): ElementList
    {
        /** @var ElementList<UserTask> $buffer */
        $buffer = $this->findAll(lcfirst('UserTask'));

        return $buffer;
    }

    public function findUserTask(string $id): ?UserTask
    {
        /** @var UserTask|null $buffer */
        $buffer = $this->find('UserTask', $id);

        return $buffer;
    }

    public function getUserTask(string $id): UserTask
    {
        /** @var UserTask $buffer */
        $buffer = $this->get('UserTask', $id);

        return $buffer;
    }

    protected function createAbstractElement(DOMElement $element, Bpmn $bpmn): AbstractElement
    {
        return AbstractElement::createElement($element, $bpmn);
    }

    /**
     * @return ElementList<AbstractElement>
     */
    private function findAll(string $name): ElementList
    {
        /** @var ElementList<AbstractElement> $elements */
        $elements = $this->getElementListByTagName($name);

        return $elements;
    }

    private function find(string $elementName, string $elementId): ?AbstractElement
    {
        return $this->findAll(lcfirst($elementName))->find($elementId);
    }

    private function get(string $elementName, string $elementId): AbstractElement
    {
        $element = $this->findAll(lcfirst($elementName))->find($elementId);

        if ($element instanceof AbstractElement) {
            return $element;
        }

        throw new LogicException(sprintf('No "%s" element with id "%s" found.', $elementName, $elementId));
    }

    /**
     * @return ElementList<AbstractElement>
     */
    private function getElementListByTagName(string $name): ElementList
    {
        $nodes = $this->getElementsByTagName($name);

        $buffer = [];
        /** @var DOMElement $element */
        foreach ($nodes as $element) {
            $buffer[] = $this->createAbstractElement($element, $this);
        }

        return new ElementList($buffer);
    }
}
