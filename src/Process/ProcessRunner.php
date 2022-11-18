<?php

namespace Scopeli\FlowBundle\Process;

use Scopeli\FlowBundle\Element\Activity;
use Scopeli\FlowBundle\Element\BoundaryEvent;
use Scopeli\FlowBundle\Element\CallActivity;
use Scopeli\FlowBundle\Element\EndEvent;
use Scopeli\FlowBundle\Element\ExclusiveGateway;
use Scopeli\FlowBundle\Element\Expression;
use Scopeli\FlowBundle\Element\FlowElement;
use Scopeli\FlowBundle\Element\FlowNode;
use Scopeli\FlowBundle\Element\Gateway;
use Scopeli\FlowBundle\Element\InclusiveGateway;
use Scopeli\FlowBundle\Element\IntermediateCatchEvent;
use Scopeli\FlowBundle\Element\ManualTask;
use Scopeli\FlowBundle\Element\Message;
use Scopeli\FlowBundle\Element\MessageEventDefinition;
use Scopeli\FlowBundle\Element\ParallelGateway;
use Scopeli\FlowBundle\Element\ReceiveTask;
use Scopeli\FlowBundle\Element\ScriptTask;
use Scopeli\FlowBundle\Element\SendTask;
use Scopeli\FlowBundle\Element\SequenceFlow;
use Scopeli\FlowBundle\Element\ServiceTask;
use Scopeli\FlowBundle\Element\StartEvent;
use Scopeli\FlowBundle\Element\SubProcess;
use Scopeli\FlowBundle\Element\Task;
use Scopeli\FlowBundle\Element\UserTask;
use Scopeli\FlowBundle\Event\ActivityEvent;
use Scopeli\FlowBundle\Event\ActivityEvents;
use Scopeli\FlowBundle\Event\OperationEvent;
use Scopeli\FlowBundle\Event\OperationEvents;
use Scopeli\FlowBundle\Event\ProcessInstanceEvent;
use Scopeli\FlowBundle\Event\ProcessInstanceEvents;
use Scopeli\FlowBundle\Exception\InvalidArgumentException;
use Scopeli\FlowBundle\Exception\LogicException;
use Scopeli\FlowBundle\Exception\NoSelectetedSequenceFlowException;
use Scopeli\FlowBundle\Exception\ProcessInstanceNotFoundException;
use Scopeli\FlowBundle\Exception\RuntimeException;
use Scopeli\FlowBundle\Script\ScriptRunner;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ProcessRunner implements ProcessRunnerInterface
{
    protected ProcessInstanceRepositoryInterface $processInstanceRepository;

    private ProcessDefinitionRepositoryInterface $processDefinitionRepository;

    private ScriptRunner $scriptRunner;

    protected EventDispatcherInterface $eventDispatcher;

    protected ?ProcessInstanceInterface $processInstance = null;

    public function __construct(
        ProcessInstanceRepositoryInterface $processInstanceRepository,
        ProcessDefinitionRepositoryInterface $processDefinitionRepository,
        ScriptRunner $scriptRunner,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->processInstanceRepository = $processInstanceRepository;
        $this->processDefinitionRepository = $processDefinitionRepository;
        $this->scriptRunner = $scriptRunner;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string|int $processDefinitionId
     */
    public function createProcessInstance($processDefinitionId): ProcessInstanceInterface
    {
        if (!is_string($processDefinitionId) && !is_int($processDefinitionId)) {
            throw new InvalidArgumentException('$processDefinitionId must be of type string or integer.');
        }

        $this->addProcessInstance($processDefinitionId);

        return $this->removeProcessInstance();
    }

    public function start(
        string $processInstanceId,
        ?string $startEventId = null,
        array $processData = []
    ): ProcessInstanceInterface {
        $this->loadProcessInstance($processInstanceId, $processData);

        if ($this->getProcessInstance()->isStarted()) {
            throw new RuntimeException(sprintf('Process instance "%s" already started.', $processInstanceId));
        }

        if (is_string($startEventId)) {
            $startEvent = $this->getProcessInstance()->getBpmn()->getStartEvent($startEventId);
        } else {
            $startEvent = $this->getProcessInstance()->getBpmn()->findAllStartEvent()->get(0);
        }

        $this->startProcessInstance($startEvent->getId());
        $this->run();

        return $this->removeProcessInstance();
    }

    public function complete(
        string $processInstanceId,
        string $activityId,
        array $processData = []
    ): ProcessInstanceInterface {
        $this->loadProcessInstance($processInstanceId, $processData);

        $token = $this->getProcessInstance()->findTokenByCurrentId($activityId);
        $token->setCompleting();

        $this->run();

        return $this->removeProcessInstance();
    }

    public function message(
        string $processInstanceId,
        string $name,
        array $processData = []
    ): ProcessInstanceInterface {
        $this->loadProcessInstance($processInstanceId, $processData);

        $message = $this->getProcessInstance()->getBpmn()->getMessageByName($name);

        $messageReferences = $message->getBpmn()->findByMessageRef($message->getId());
        if (!$messageReferences->hasElements()) {
            throw new RuntimeException(sprintf('No elements with reference to message "%s" found.', $name));
        }

        // If process instance is not started, try to find startEvent with this message.
        if (is_null($this->getProcessInstance()->getState())) {
            $startEvents = $this->getProcessInstance()->getBpmn()->findAllStartEvent();
            /** @var StartEvent $startEvent */
            foreach ($startEvents as $startEvent) {
                $messageEventDefinition = $startEvent->hasMessageEventDefinition() ? $startEvent->getMessageEventDefinition()->get(0) : null;
                if ($messageEventDefinition instanceof MessageEventDefinition) {
                    $messageRef = $messageEventDefinition->getMessageRef();
                    if ($messageRef instanceof Message && $name === $message->getName()) {
                        $this->startProcessInstance($startEvent->getId());
                        $this->run();

                        return $this->removeProcessInstance();
                    }
                }
            }

            throw new RuntimeException(sprintf('Process is not started and no StartEvent with message "%s" found.', $name));
        }

        $hasCase = false;

        // Check for active intermediate element.
        foreach ($this->getProcessInstance()->getTokens() as $token) {
            $tokenElement = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());

            // Check for ReceiveTask.
            if ($tokenElement instanceof ReceiveTask) {
                $messageRef = $tokenElement->getMessageRef();
                if ($messageRef instanceof Message && $name === $messageRef->getName()) {
                    $hasCase = true;
                    $token->setCompleting();
                }
            }

            // Check for IntermediateCatchEvent.
            if ($tokenElement instanceof IntermediateCatchEvent) {
                $messageEventDefinition = $tokenElement->hasMessageEventDefinition() ? $tokenElement->getMessageEventDefinition()->get(0) : null;
                if ($messageEventDefinition instanceof MessageEventDefinition) {
                    $messageRef = $messageEventDefinition->getMessageRef();
                    if ($messageRef instanceof Message && $name === $messageRef->getName()) {
                        $hasCase = true;
                        $token->setCompleting();
                    }
                }
            }

            // Check for BoundaryEvents.
            if ($tokenElement instanceof Activity) {
                $boundaryEvents = $tokenElement->getBpmn()->findAllBoundaryEvent();
                /** @var BoundaryEvent $boundaryEvent */
                foreach ($boundaryEvents as $boundaryEvent) {
                    if ($boundaryEvent->getAttachedToRef()->getId() === $tokenElement->getId()) {
                        $messageEventDefinition = $boundaryEvent->hasMessageEventDefinition() ? $boundaryEvent->getMessageEventDefinition()->get(0) : null;
                        if ($messageEventDefinition instanceof MessageEventDefinition) {
                            $messageRef = $messageEventDefinition->getMessageRef();
                            if ($messageRef instanceof Message && $name === $messageRef->getName()) {
                                $hasCase = true;
                                if ($boundaryEvent->getCancelActivity()) {
                                    // ToDo: Make central function for remove all tokens.
                                    foreach ($this->getProcessInstance()->getTokens() as $token) {
                                        $this->getProcessInstance()->removeToken($token, false);
                                    }
                                }

                                $this->getProcessInstance()->createToken($boundaryEvent->getId());
                            }
                        }
                    }
                }
            }
        }

        // Has any case to run?
        if ($hasCase) {
            $this->run();

            return $this->removeProcessInstance();
        }

        throw new RuntimeException(sprintf('No possible case for the message "%s" found', $name));
    }

    private function run(): void
    {
        /**
         * Set tokens state to "ready" if it is possible.
         * @see https://www.omg.org/spec/BPMN/2.0/PDF Page 428
         */
        if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_INACTIVE])) {
            foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_INACTIVE]) as $token) {
                $flowNode = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());

                switch (true) {
                    case $flowNode instanceof ParallelGateway:
                    case $flowNode instanceof InclusiveGateway:
                        $this->readyParallelOrInclusiveGateway($token, $flowNode);
                        break;
                    default:
                        $token->setReady();
                }

                if ($flowNode instanceof Activity && $token->isReady()) {
                    $this->dispatchActivityEvent($flowNode, ActivityEvents::READY);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }
            }
        }

        /**
         * Set tokens state to "active" if it is possible.
         * @see https://www.omg.org/spec/BPMN/2.0/PDF Page 428
         */
        if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_READY])) {
            foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_READY]) as $token) {
                $flowNode = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());
                $token->setActive();
                if ($flowNode instanceof Activity && $token->isActive()) {
                    $this->dispatchActivityEvent($flowNode, ActivityEvents::ACTIVE);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }
            }
        }

        /**
         * Set tokens state to "completing" if it is possible.
         * @see https://www.omg.org/spec/BPMN/2.0/PDF Page 428
         */
        if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_ACTIVE])) {
            foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_ACTIVE]) as $token) {
                $flowNode = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());

                switch (true) {
                    case $flowNode instanceof SendTask:
                    case $flowNode instanceof ServiceTask:
                        $this->runOperation($flowNode);
                        $token->setCompleting();
                        break;
                    case $flowNode instanceof ScriptTask:
                        // ToDo: Add support for script (e.g. ScriptTwig)
                        $this->runScriptTask($flowNode);
                        $token->setCompleting();
                        break;
                    case $flowNode instanceof Task:
                    case $flowNode instanceof UserTask:
                    case $flowNode instanceof ManualTask:
                    case $flowNode instanceof ReceiveTask:
                    case $flowNode instanceof IntermediateCatchEvent && $flowNode->hasMessageEventDefinition():
                        break;
                    case $flowNode instanceof SequenceFlow:
                    case $flowNode instanceof StartEvent:
                    case $flowNode instanceof EndEvent:
                    case $flowNode instanceof ExclusiveGateway:
                    case $flowNode instanceof InclusiveGateway:
                    case $flowNode instanceof ParallelGateway:
                    // ToDo: Add logic and test for calling CallActivity and SubProcess.
                    case $flowNode instanceof CallActivity:
                    case $flowNode instanceof SubProcess:
                    case $flowNode instanceof BoundaryEvent && $flowNode->hasMessageEventDefinition():
                        $token->setCompleting();
                        break;
                    default:
                        throw new RuntimeException(sprintf('Flow element "%s" not supported yet!', get_class($flowNode)));
                }

                if ($flowNode instanceof Activity && $token->isCompleting()) {
                    $this->dispatchActivityEvent($flowNode, ActivityEvents::COMPLETING);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }
            }
        }

        /**
         * Set tokens state to "completed" if it is possible.
         * @see https://www.omg.org/spec/BPMN/2.0/PDF Page 428
         */
        if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_COMPLETING])) {
            foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_COMPLETING]) as $token) {
                $flowNode = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());
                $token->setCompleted();
                if ($flowNode instanceof Activity && $token->isCompleted()) {
                    $this->dispatchActivityEvent($flowNode, ActivityEvents::COMPLETED);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }
            }
        }

        /**
         * Set tokens state to "closed" if it is possible.
         * @see https://www.omg.org/spec/BPMN/2.0/PDF Page 428
         */
        if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_COMPLETED])) {
            foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_COMPLETED]) as $token) {
                $flowNode = $this->getProcessInstance()->getBpmn()->getById($token->getCurrentId());
                $token->setClosed();
                if ($flowNode instanceof Activity && $token->isClosed()) {
                    $this->dispatchActivityEvent($flowNode, ActivityEvents::CLOSED);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }
            }

            if ($this->getProcessInstance()->hasTokenByState([TokenInterface::STATE_CLOSED])) {
                foreach ($this->getProcessInstance()->findTokenByState([TokenInterface::STATE_CLOSED]) as $token) {
                    $flowElement = $this->getProcessInstance()->getBpmn()->getFlowElementById($token->getCurrentId());

                    switch (true) {
                        case $flowElement instanceof EndEvent:
                            $this->closeEndEvent($token, $flowElement);
                            break;
                        case $flowElement instanceof ExclusiveGateway:
                            $this->closeExclusiveGateway($token, $flowElement);
                            break;
                        case $flowElement instanceof InclusiveGateway:
                            $this->closeInclusiveGateway($token, $flowElement);
                            break;
                        case $flowElement instanceof ParallelGateway:
                            $this->closeParallelGateway($token, $flowElement);
                            break;
                        default:
                            $this->closeFlowElement($token, $flowElement);
                    }

                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }

                if ($this->getProcessInstance()->getTokens() === []) {
                    $this->getProcessInstance()->setEnded();
                    $this->dispatchProcessInstanceEvent(ProcessInstanceEvents::ENDED);
                    $this->processInstanceRepository->saveProcessInstance($this->getProcessInstance());
                }

                if ($this->getProcessInstance()->isStarted()) {
                    $this->run();
                }
            }
        }
    }

    private function readyParallelOrInclusiveGateway(TokenInterface $currentToken, Gateway $gateway): void
    {
        $tokens = $this->getProcessInstance()->getTokens();

        $noTokenToWait = true;
        foreach ($tokens as $token) {
            if ($token !== $currentToken) {
                $tokenElement = $this->getProcessInstance()->getBpmn()->getFlowElementById($token->getCurrentId());
                if ($tokenElement instanceof SequenceFlow) {
                    $tokenElement = $tokenElement->getTargetRef();
                }

                assert($tokenElement instanceof FlowNode);

                $isTokenLeadsTo = $this->getProcessInstance()->getBpmn()->isLeadsTo($tokenElement, $gateway);
                if ($isTokenLeadsTo) {
                    $noTokenToWait = false;
                    break;
                }
            }
        }

        if ($noTokenToWait) {
            $currentToken->setReady();
        }
    }

    private function closeFlowElement(TokenInterface $token, FlowElement $flowElement): void
    {
        if ($flowElement instanceof SequenceFlow) {
            $target = $flowElement->getTargetRef();
        } elseif ($flowElement instanceof FlowNode) {
            $target = $flowElement->getOutgoing()->get(0);
        } else {
            throw new LogicException('Can not select a target, because the $flowElement is not a SequenceFlow or FlowNode');
        }

        $this->getProcessInstance()->flowToken($token, $target->getId());
    }

    private function closeInclusiveGateway(TokenInterface $token, InclusiveGateway $inclusiveGateway): void
    {
        $outgoings = $inclusiveGateway->getOutgoing();
        $selectedOutgoings = [];

        if (count($outgoings) === 1) {
            // If only one outgoing, select this one.
            $selectedOutgoings[] = $outgoings->get(0);
        } elseif (count($outgoings) > 1) {
            // If more then one, try to find true expressions.
            /** @var SequenceFlow $outgoing */
            foreach ($outgoings as $outgoing) {
                if ($outgoing->getId() !== $inclusiveGateway->getDefault()) {
                    $conditionExpression = $outgoing->getConditionExpression();
                    if ($conditionExpression instanceof Expression) {
                        $expression = $conditionExpression->getElement()->nodeValue;
                        if ($this->evaluateExpression($expression, $this->getProcessInstance()->getProcessData())) {
                            $selectedOutgoings[] = $outgoing;
                        }
                    }
                }
            }
        }

        if ([] === $selectedOutgoings && null !== $inclusiveGateway->getDefault()) {
            $selectedOutgoings[] = $inclusiveGateway->getDefault();
        }

        if ([] === $selectedOutgoings) {
            throw new NoSelectetedSequenceFlowException($inclusiveGateway->getId());
        }

        $firstToken = null;
        /** @var SequenceFlow $selectedOutgoing */
        foreach ($selectedOutgoings as $selectedOutgoing) {
            if (!$firstToken instanceof TokenInterface) {
                $firstToken = clone $token;
                $this->getProcessInstance()->flowToken($token, $selectedOutgoing->getId());
            } else {
                $this->getProcessInstance()->cloneToken($firstToken, $selectedOutgoing->getId());
            }
        }
    }

    private function closeExclusiveGateway(TokenInterface $token, ExclusiveGateway $exclusiveGateway): void
    {
        $outgoings = $exclusiveGateway->getOutgoing();
        $selectedOutgoing = null;

        if (count($outgoings) === 1) {
            // If only one outgoing, select this one.
            $selectedOutgoing = $outgoings->get(0);
        } elseif (count($outgoings) > 1) {
            // If more then one, try to find one with a true expression.
            /** @var SequenceFlow $outgoing */
            foreach ($outgoings as $outgoing) {
                if ($outgoing->getId() !== $exclusiveGateway->getDefault()) {
                    $conditionExpression = $outgoing->getConditionExpression();
                    if ($conditionExpression instanceof Expression) {
                        $expression = $conditionExpression->getElement()->nodeValue;
                        if ($this->evaluateExpression($expression, $this->getProcessInstance()->getProcessData())) {
                            $selectedOutgoing = $outgoing;
                        }
                    }
                }
            }
        }

        if (null === $selectedOutgoing && null !== $exclusiveGateway->getDefault()) {
            $selectedOutgoing = $exclusiveGateway->getDefault();
        }

        if (null === $selectedOutgoing) {
            throw new NoSelectetedSequenceFlowException($exclusiveGateway->getId());
        }

        $this->getProcessInstance()->flowToken($token, $selectedOutgoing->getId());
    }

    private function closeParallelGateway(TokenInterface $token, ParallelGateway $parallelGateway): void
    {
        $outgoings = $parallelGateway->getOutgoing();

        if (!$outgoings->hasElements()) {
            throw new LogicException(sprintf('No outgoing sequence flow found on "%s".', $token->getId()));
        }

        $masterToken = null;
        /** @var SequenceFlow $outgoing */
        foreach ($outgoings as $outgoing) {
            if (!$masterToken instanceof TokenInterface) {
                $masterToken = clone $token;
                $this->getProcessInstance()->flowToken($token, $outgoing->getId());
            } else {
                $this->getProcessInstance()->cloneToken($masterToken, $outgoing->getId());
            }
        }
    }

    private function closeEndEvent(TokenInterface $token, EndEvent $endEvent): void
    {
        $this->getProcessInstance()->removeToken($token);

        // Has a TerminateEventDefinition, remove all other Tokens.
        if ($endEvent->hasTerminateEventDefinition()) {
            foreach ($this->getProcessInstance()->getTokens() as $token) {
                $this->getProcessInstance()->removeToken($token, false);
            }
        }
    }

    private function runOperation(Activity $activity): void
    {
        $event = new OperationEvent($this->getProcessInstance(), $activity);
        $this->eventDispatcher->dispatch($event, OperationEvents::RUN);
        $this->setProcessInstance($event->getProcessInstance());
    }

    private function runScriptTask(ScriptTask $scriptTask): void
    {
        if (is_string($scriptTask->getScriptFormat()) && is_string($scriptTask->getScript())) {
            $result = $this->scriptRunner->run(
                $scriptTask->getScriptFormat(),
                $scriptTask->getScript(),
                $this->getProcessInstance()->getProcessData()
            );

            if ($scriptTask->hasResultVariable()) {
                $this->getProcessInstance()->mergeProcessData([
                    $scriptTask->getResultVariable() => $result,
                ]);
            }
        }
    }

    /**
     * @param mixed[] $context
     */
    private function evaluateExpression(string $expression, array $context = []): bool
    {
        $expressionLanguage = new ExpressionLanguage();

        $result = $expressionLanguage->evaluate($expression, $context);
        if (!is_bool($result)) {
            throw new RuntimeException('The expression must return a boolean');
        }

        return $result;
    }

    private function setProcessInstance(ProcessInstanceInterface $processInstance): void
    {
        $this->processInstance = $processInstance;
    }

    private function getProcessInstance(): ProcessInstanceInterface
    {
        if (!$this->processInstance instanceof ProcessInstanceInterface) {
            throw new LogicException('No process instance loaded.');
        }

        return $this->processInstance;
    }

    /**
     * @param string|int $processDefinitionId
     * @param mixed[] $processData
     */
    private function addProcessInstance($processDefinitionId, array $processData = []): void
    {
        $processDefinition = $this->processDefinitionRepository->findProcessDefinition($processDefinitionId);
        if (!is_string($processDefinition)) {
            throw new RuntimeException(sprintf('No process definition found with id "%s".', $processDefinitionId));
        }

        $processInstance = new ProcessInstance($processDefinition, $processData);
        $this->setProcessInstance($processInstance);
        $this->processInstanceRepository->addProcessInstance($processInstance);

        $this->dispatchProcessInstanceEvent(ProcessInstanceEvents::STARTED);
    }

    private function loadProcessInstance(string $processInstanceId, array $processData = []): void
    {
        $processInstance = $this->processInstanceRepository->findProcessInstance($processInstanceId);
        if (!$processInstance instanceof ProcessInstanceInterface) {
            throw new ProcessInstanceNotFoundException($processInstanceId);
        }

        $processInstance->mergeProcessData($processData);
        $this->setProcessInstance($processInstance);
    }

    private function startProcessInstance(string $id): void
    {
        $this->getProcessInstance()->setStarted();
        $this->getProcessInstance()->createToken($id);
        $this->dispatchProcessInstanceEvent(ProcessInstanceEvents::STARTED);
    }

    private function removeProcessInstance(): ProcessInstanceInterface
    {
        $processInstance = $this->getProcessInstance();
        $this->processInstance = null;

        return $processInstance;
    }

    public function dispatchProcessInstanceEvent(string $eventName): void
    {
        $event = new ProcessInstanceEvent($this->getProcessInstance());
        $this->eventDispatcher->dispatch($event, $eventName);
        $this->setProcessInstance($event->getProcessInstance());
    }

    public function dispatchActivityEvent(Activity $activity, string $eventName): void
    {
        $event = new ActivityEvent($this->getProcessInstance(), $activity);
        $this->eventDispatcher->dispatch($event, $eventName);
        $this->setProcessInstance($event->getProcessInstance());
    }
}
