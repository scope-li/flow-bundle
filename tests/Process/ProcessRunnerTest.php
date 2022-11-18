<?php

namespace Scopeli\FlowBundle\Process;

use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\Element\SendTask;
use Scopeli\FlowBundle\Element\ServiceTask;
use Scopeli\FlowBundle\Event\OperationEvent;
use Scopeli\FlowBundle\Event\OperationEvents;
use Scopeli\FlowBundle\ProcessAssertTrait;
use Scopeli\FlowBundle\ProcessDefinitionRepositoryTrait;
use Scopeli\FlowBundle\ScriptRunnerTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ProcessRunnerTest extends TestCase
{
    use ProcessAssertTrait;
    use ProcessDefinitionRepositoryTrait;
    use ScriptRunnerTrait;

    private ProcessRunner $processRunner;
    private EventDispatcherInterface $eventDispatcher;
    private array $processFlowLogCache = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->processFlowLogCache = [];
        $this->eventDispatcher = new EventDispatcher();
        $this->processRunner = new ProcessRunner(
            new ProcessInstanceRepository(),
            $this->getProcessDefinitionRepository(),
            $this->getScriptRunner(),
            $this->eventDispatcher
        );
    }

    public function testTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('TaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_Task', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task');
        $this->assertProcessFlowLog([
            ['id' => 'Task', 'data' => []],
            ['id' => 'Task_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testSendTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('SendTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_SendTask', 'data' => []],
            ['id' => 'SendTask', 'data' => []],
            ['id' => 'SendTask_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testReceiveTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('ReceiveTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_ReceiveTask', 'data' => []],
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'ReceiveTask');
        $this->assertProcessFlowLog([
            ['id' => 'ReceiveTask', 'data' => []],
            ['id' => 'ReceiveTask_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testUserTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('UserTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_UserTask', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'UserTask' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'UserTask');
        $this->assertProcessFlowLog([
            ['id' => 'UserTask', 'data' => []],
            ['id' => 'UserTask_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testManualTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('ManualTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_ManualTask', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'ManualTask' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'ManualTask');
        $this->assertProcessFlowLog([
            ['id' => 'ManualTask', 'data' => []],
            ['id' => 'ManualTask_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testServiceTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('ServiceTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_ServiceTask', 'data' => []],
            ['id' => 'ServiceTask', 'data' => []],
            ['id' => 'ServiceTask_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testScriptTaskSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('ScriptTaskSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_ScriptTask', 'data' => []],
            ['id' => 'ScriptTask', 'data' => ['calcResult' => '5']],
            ['id' => 'ScriptTask_EndEvent', 'data' => ['calcResult' => '5']],
            ['id' => 'EndEvent', 'data' => ['calcResult' => '5']],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testCallActivitySimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('CallActivitySimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_CallActivity', 'data' => []],
            ['id' => 'CallActivity', 'data' => []],
            ['id' => 'CallActivity_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testSubProcessSimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('SubProcessSimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_SubProcess', 'data' => []],
            ['id' => 'SubProcess', 'data' => []],
            ['id' => 'SubProcess_EndEvent', 'data' => []],
            ['id' => 'EndEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testExclusiveGatewaySimpleOverTask1()
    {
        $processInstance = $this->processRunner->createProcessInstance('ExclusiveGatewaySimple');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['approved' => false]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['approved' => false]],
            ['id' => 'StartEvent_ExclusiveGatway1', 'data' => ['approved' => false]],
            ['id' => 'ExclusiveGatway1', 'data' => ['approved' => false]],
            ['id' => 'ExclusiveGatway1_Task1', 'data' => ['approved' => false]],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task1');
        $this->assertProcessFlowLog([
            ['id' => 'Task1', 'data' => ['approved' => false]],
            ['id' => 'Task1_ExclusiveGatway2', 'data' => ['approved' => false]],
            ['id' => 'ExclusiveGatway2', 'data' => ['approved' => false]],
            ['id' => 'ExclusiveGatway2_EndEvent', 'data' => ['approved' => false]],
            ['id' => 'EndEvent', 'data' => ['approved' => false]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testExclusiveGatewaySimpleOverTask2()
    {
        $processInstance = $this->processRunner->createProcessInstance('ExclusiveGatewaySimple');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['approved' => true]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['approved' => true]],
            ['id' => 'StartEvent_ExclusiveGatway1', 'data' => ['approved' => true]],
            ['id' => 'ExclusiveGatway1', 'data' => ['approved' => true]],
            ['id' => 'ExclusiveGatway1_Task2', 'data' => ['approved' => true]],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => ['approved' => true]],
            ['id' => 'Task2_ExclusiveGatway2', 'data' => ['approved' => true]],
            ['id' => 'ExclusiveGatway2', 'data' => ['approved' => true]],
            ['id' => 'ExclusiveGatway2_EndEvent', 'data' => ['approved' => true]],
            ['id' => 'EndEvent', 'data' => ['approved' => true]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testInclusiveGatewaySimpleWithTask1()
    {
        $processInstance = $this->processRunner->createProcessInstance('InclusiveGatewaySimple');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['value' => 0]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['value' => 0]],
            ['id' => 'StartEvent_InclusiveGatway1', 'data' => ['value' => 0]],
            ['id' => 'InclusiveGatway1', 'data' => ['value' => 0]],
            ['id' => 'InclusiveGatway1_Task1', 'data' => ['value' => 0]],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task1');
        $this->assertProcessFlowLog([
            ['id' => 'Task1', 'data' => ['value' => 0]],
            ['id' => 'Task1_InclusiveGatway2', 'data' => ['value' => 0]],
            ['id' => 'InclusiveGatway2', 'data' => ['value' => 0]],
            ['id' => 'InclusiveGatway2_EndEvent', 'data' => ['value' => 0]],
            ['id' => 'EndEvent', 'data' => ['value' => 0]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testInclusiveGatewaySimpleWithTask23()
    {
        $processInstance = $this->processRunner->createProcessInstance('InclusiveGatewaySimple');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['value' => 3]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['value' => 3]],
            ['id' => 'StartEvent_InclusiveGatway1', 'data' => ['value' => 3]],
            ['id' => 'InclusiveGatway1', 'data' => ['value' => 3]],
            ['id' => 'InclusiveGatway1_Task2', 'data' => ['value' => 3]],
            ['id' => 'InclusiveGatway1_Task3', 'data' => ['value' => 3]],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
            'Task3' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => ['value' => 3]],
            ['id' => 'Task2_InclusiveGatway2', 'data' => ['value' => 3]],
        ], $processInstance);
        $this->assertTokens([
            'Task3' => Token::STATE_ACTIVE,
            'InclusiveGatway2' => Token::STATE_INACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task3');
        $this->assertProcessFlowLog([
            ['id' => 'Task3', 'data' => ['value' => 3]],
            ['id' => 'Task3_InclusiveGatway2', 'data' => ['value' => 3]],
            ['id' => 'InclusiveGatway2', 'data' => ['value' => 3]],
            ['id' => 'InclusiveGatway2_EndEvent', 'data' => ['value' => 3]],
            ['id' => 'EndEvent', 'data' => ['value' => 3]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testInclusiveGatewayComplex()
    {
        $processInstance = $this->processRunner->createProcessInstance('InclusiveGatewayComplex');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['value' => 4]);

        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['value' => 4]],
            ['id' => 'StartEvent_InclusiveGatway1', 'data' => ['value' => 4]],
            ['id' => 'InclusiveGatway1', 'data' => ['value' => 4]],
            ['id' => 'InclusiveGatway1_Task2', 'data' => ['value' => 4]],
            ['id' => 'InclusiveGatway1_Task3a', 'data' => ['value' => 4]],
            ['id' => 'InclusiveGatway1_Task4a', 'data' => ['value' => 4]],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
            'Task3a' => Token::STATE_ACTIVE,
            'Task4a' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => ['value' => 4]],
            ['id' => 'Task2_InclusiveGatway2', 'data' => ['value' => 4]],
        ], $processInstance);
        $this->assertTokens([
            'InclusiveGatway2' => Token::STATE_INACTIVE,
            'Task3a' => Token::STATE_ACTIVE,
            'Task4a' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task3a');
        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task4a');
        $this->assertProcessFlowLog([
            ['id' => 'Task3a', 'data' => ['value' => 4]],
            ['id' => 'Task3a_Task3b', 'data' => ['value' => 4]],
            ['id' => 'Task4a', 'data' => ['value' => 4]],
            ['id' => 'Task4a_Task4b', 'data' => ['value' => 4]],
        ], $processInstance);
        $this->assertTokens([
            'InclusiveGatway2' => Token::STATE_INACTIVE,
            'Task3b' => Token::STATE_ACTIVE,
            'Task4b' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task3b');
        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task4b', ['rerun' => true]);
        $this->assertProcessFlowLog([
            ['id' => 'Task3b', 'data' => ['value' => 4]],
            ['id' => 'Task3b_InclusiveGatway2', 'data' => ['value' => 4]],
            ['id' => 'Task4b', 'data' => ['value' => 4, 'rerun' => true]],
            ['id' => 'Task4b_ExclusivGateway1', 'data' => ['value' => 4, 'rerun' => true]],
            ['id' => 'ExclusivGateway1', 'data' => ['value' => 4, 'rerun' => true]],
            ['id' => 'ExclusivGateway1_Task4a', 'data' => ['value' => 4, 'rerun' => true]],
        ], $processInstance);
        $this->assertTokens([
            'InclusiveGatway2' => Token::STATE_INACTIVE,
            'Task4a' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task4a');
        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task4b', ['rerun' => false]);
        $this->assertProcessFlowLog([
            ['id' => 'Task4a', 'data' => ['value' => 4, 'rerun' => true]],
            ['id' => 'Task4a_Task4b', 'data' => ['value' => 4, 'rerun' => true]],
            ['id' => 'Task4b', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'Task4b_ExclusivGateway1', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'ExclusivGateway1', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'ExclusivGateway1_InclusiveGatway2', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'InclusiveGatway2', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'InclusiveGatway2_EndEvent', 'data' => ['value' => 4, 'rerun' => false]],
            ['id' => 'EndEvent', 'data' => ['value' => 4, 'rerun' => false]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testParallelGatewaySimple()
    {
        $processInstance = $this->processRunner->createProcessInstance('ParallelGatewaySimple');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent1', 'data' => []],
            ['id' => 'StartEvent1_ParallelGateway1', 'data' => []],
            ['id' => 'ParallelGateway1', 'data' => []],
            ['id' => 'ParallelGateway1_Task1', 'data' => []],
            ['id' => 'ParallelGateway1_Task2', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task1');
        $this->assertProcessFlowLog([
            ['id' => 'Task1', 'data' => []],
            ['id' => 'Task1_ParallelGateway2', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
            'ParallelGateway2' => Token::STATE_INACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => []],
            ['id' => 'Task2_ParallelGateway2', 'data' => []],
            ['id' => 'ParallelGateway2', 'data' => []],
            ['id' => 'ParallelGateway2_EndEvent1', 'data' => []],
            ['id' => 'EndEvent1', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testServiceTaskWithOperation()
    {
        $this->eventDispatcher->addListener(OperationEvents::RUN, function (OperationEvent $operationEvent) {
            $operationEvent->setProcessData(['name' => get_class($operationEvent->getActivity())]);
        });

        $processInstance = $this->processRunner->createProcessInstance('ServiceTaskWithOperation');
        $processInstance = $this->processRunner->start($processInstance->getId());
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => []],
            ['id' => 'StartEvent_ServiceTask', 'data' => []],
            ['id' => 'ServiceTask', 'data' => ['name' => ServiceTask::class]],
            ['id' => 'ServiceTask_SendTask', 'data' => ['name' => ServiceTask::class]],
            ['id' => 'SendTask', 'data' => ['name' => SendTask::class]],
            ['id' => 'SendTask_EndEvent', 'data' => ['name' => SendTask::class]],
            ['id' => 'EndEvent', 'data' => ['name' => SendTask::class]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testTerminateEventWithTerminateEvent()
    {
        $processInstance = $this->processRunner->createProcessInstance('TerminateEvent');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['case' => 2]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['case' => 2]],
            ['id' => 'StartEvent_InclusiveGateway', 'data' => ['case' => 2]],
            ['id' => 'InclusiveGateway', 'data' => ['case' => 2]],
            ['id' => 'InclusiveGateway_Task1', 'data' => ['case' => 2]],
            ['id' => 'InclusiveGateway_Task2', 'data' => ['case' => 2]],
            ['id' => 'InclusiveGateway_Task3', 'data' => ['case' => 2]],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
            'Task2' => Token::STATE_ACTIVE,
            'Task3' => Token::STATE_ACTIVE,
        ], $processInstance);

        $this->processRunner->complete($processInstance->getId(), 'Task3');
        $this->assertProcessFlowLog([
            ['id' => 'Task3', 'data' => ['case' => 2]],
            ['id' => 'Task3_TerminateEvent', 'data' => ['case' => 2]],
            ['id' => 'TerminateEvent', 'data' => ['case' => 2]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);

        $this->assertProcessInstanceEnded($processInstance);
    }

    public function testTerminateEventWithoutTerminateEvent()
    {
        $processInstance = $this->processRunner->createProcessInstance('TerminateEvent');
        $processInstance = $this->processRunner->start($processInstance->getId(), null, ['case' => 1]);
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent', 'data' => ['case' => 1]],
            ['id' => 'StartEvent_InclusiveGateway', 'data' => ['case' => 1]],
            ['id' => 'InclusiveGateway', 'data' => ['case' => 1]],
            ['id' => 'InclusiveGateway_Task1', 'data' => ['case' => 1]],
            ['id' => 'InclusiveGateway_Task2', 'data' => ['case' => 1]],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);

        $this->processRunner->complete($processInstance->getId(), 'Task1');
        $this->assertProcessFlowLog([
            ['id' => 'Task1', 'data' => ['case' => 1]],
            ['id' => 'Task1_EndEvent1', 'data' => ['case' => 1]],
            ['id' => 'EndEvent1', 'data' => ['case' => 1]],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);
        $this->assertProcessInstanceStarted($processInstance);

        $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => ['case' => 1]],
            ['id' => 'Task2_EndEvent2', 'data' => ['case' => 1]],
            ['id' => 'EndEvent2', 'data' => ['case' => 1]],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
        $this->assertProcessInstanceEnded($processInstance);
    }

    public function testMessageStart(): void
    {
        $processInstance = $this->processRunner->createProcessInstance('Message');
        $processInstance = $this->processRunner->message($processInstance->getId(), 'StartMessage');
        $this->assertProcessFlowLog([
            ['id' => 'MessageStartEvent', 'data' => []],
            ['id' => 'MessageStartEvent_ExclusiveGateway', 'data' => []],
            ['id' => 'ExclusiveGateway', 'data' => []],
            ['id' => 'ExclusiveGateway_ReceiveTask', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'ReceiveTask' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->message($processInstance->getId(), 'ReceiveTask');
        $this->assertProcessFlowLog([
            ['id' => 'ReceiveTask', 'data' => []],
            ['id' => 'ReceiveTask_MesssageEvent', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'MessageEvent' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->message($processInstance->getId(), 'MessageEvent');
        $this->assertProcessFlowLog([
            ['id' => 'MessageEvent', 'data' => []],
            ['id' => 'MessageEvent_EndEvent', 'data' => []],
            ['id' => 'EndEvent1', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testBoundaryInterruptingMessage(): void
    {
        $processInstance = $this->processRunner->createProcessInstance('Message');
        $processInstance = $this->processRunner->start($processInstance->getId(), 'StartEvent2');
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent2', 'data' => []],
            ['id' => 'StartEvent2_Task1', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task1' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->message($processInstance->getId(), 'BoundaryInterrupting');
        $this->assertProcessFlowLog([
            ['id' => 'BoundaryInterrupting', 'data' => []],
            ['id' => 'BoundaryInterrupting_EndEvent3', 'data' => []],
            ['id' => 'EndEvent3', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }

    public function testBoundaryNonInterruptingMessage(): void
    {
        $processInstance = $this->processRunner->createProcessInstance('Message');
        $processInstance = $this->processRunner->start($processInstance->getId(), 'StartEvent3');
        $this->assertProcessFlowLog([
            ['id' => 'StartEvent3', 'data' => []],
            ['id' => 'StartEvent3_Task2', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->message($processInstance->getId(), 'BoundaryNonInterrupting');
        $this->assertProcessFlowLog([
            ['id' => 'BoundaryNonInterrupting', 'data' => []],
            ['id' => 'BoundaryNonInterrupting_EndEvent5', 'data' => []],
            ['id' => 'EndEvent5', 'data' => []],
        ], $processInstance);
        $this->assertTokens([
            'Task2' => Token::STATE_ACTIVE,
        ], $processInstance);

        $processInstance = $this->processRunner->complete($processInstance->getId(), 'Task2');
        $this->assertProcessFlowLog([
            ['id' => 'Task2', 'data' => []],
            ['id' => 'Task2_EndEvent4', 'data' => []],
            ['id' => 'EndEvent4', 'data' => []],
        ], $processInstance);
        $this->assertTokens([], $processInstance);
    }
}
