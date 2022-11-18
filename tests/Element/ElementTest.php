<?php

namespace Scopeli\FlowBundle\Element;

use Scopeli\FlowBundle\ElementCamunda\Connector;
use Scopeli\FlowBundle\ElementCamunda\InputOutput;
use Scopeli\FlowBundle\ProcessDefinitionRepositoryTrait;

class ElementTest extends ElementTestCase
{
    use ProcessDefinitionRepositoryTrait;

    const TYPE_NULL = 'null';
    const TYPE_LIST = 'list';
    const TYPE_CLASS = 'class';
    const TYPE_STRING = 'string';

    /**
     * @dataProvider dataGet
     */
    public function testGet(string $method, string $elementId, string $type, ?string $expected = null): void
    {
        $element = $this->bpmn->getById($elementId);
        if (self::TYPE_NULL === $type) {
            $this->assertNull($element->$method());
        } elseif (self::TYPE_LIST === $type) {
            /** @var ElementList $elements */
            $elements = $element->$method();
            $this->assertInstanceOf(ElementList::class, $elements);
            $this->assertInstanceOf($expected, $elements->get(0));
        } elseif (self::TYPE_CLASS === $type) {
            $this->assertInstanceOf($expected, $element->$method());
        } elseif (self::TYPE_STRING === $type) {
            $this->assertSame($expected, $element->$method());
        } else {
            $this->fail('Not supported type.');
        }
    }

    public function dataGet(): iterable
    {
        return [
            // EndEvent
            ['getTerminateEventDefinition', 'EndEvent1', self::TYPE_CLASS, ElementList::class],
            ['getTerminateEventDefinition', 'TerminateEndEvent1', self::TYPE_CLASS, ElementList::class],
            // BaseElement
            ['getExtensionElements', 'ServiceTask1', self::TYPE_NULL, null],
            ['getExtensionElements', 'ServiceTask2', self::TYPE_CLASS, ExtensionElements::class],
            // MessageEventDefinition
            //['getMessageRef', 'StartEvent1', self::TYPE_NULL, null],
            ['getMessageRef', 'MessageEventDefinition_1q9cqfp', self::TYPE_CLASS, Message::class],
            // Message
            ['getName', 'Message_090xf8f', self::TYPE_STRING, 'Message_ReceiveTask1'],
            // ScriptTask
            ['getResultVariable', 'ScriptTask1', self::TYPE_STRING, 'calcResult'],
            ['getScriptFormat', 'ScriptTask1', self::TYPE_STRING, 'twig'],
            ['getScript', 'ScriptTask1', self::TYPE_STRING, '{{ 2 + 3 }}'],
            // UserTask
            ['getFormKey', 'UserTask1', self::TYPE_NULL, null],
            ['getFormKey', 'UserTask2', self::TYPE_STRING, 'form_key_1'],
            ['getAssignee', 'UserTask1', self::TYPE_NULL, null],
            ['getAssignee', 'UserTask2', self::TYPE_STRING, 'ROLE_USER'],
        ];
    }

    /**
     * @dataProvider dataHas
     */
    public function testHas(string $method, string $elementId, bool $expected): void
    {
        $element = $this->bpmn->getById($elementId);
        $this->assertSame($expected, $element->$method());
    }

    public function dataHas(): iterable
    {
        return [
            // EndEvent
            ['hasTerminateEventDefinition', 'EndEvent1', false],
            ['hasTerminateEventDefinition', 'TerminateEndEvent1', true],
            // BaseElement
            ['hasExtensionElements', 'ServiceTask1', false],
            ['hasExtensionElements', 'ServiceTask2', true],
            // MessageEventDefinition
            //['hasMessageRef', 'StartEvent1', false],
            ['hasMessageRef', 'MessageEventDefinition_1q9cqfp', true],
            // Message
            ['hasName', 'Message_090xf8f', true],
            // ScriptTask
            ['hasResultVariable', 'ScriptTask1', true],
            ['hasScriptFormat', 'ScriptTask1', true],
            ['hasScript', 'ScriptTask1', true],
            // UserTask
            ['hasFormKey', 'UserTask1', false],
            ['hasFormKey', 'UserTask2', true],
            ['hasAssignee', 'UserTask1', false],
            ['hasAssignee', 'UserTask2', true],
        ];
    }

    public function testExtensionElements(): void
    {
        $serviceTask = $this->bpmn->getById('ServiceTask2');

        $this->assertTrue($serviceTask->hasExtensionElements());
        $this->assertInstanceOf(ExtensionElements::class, $serviceTask->getExtensionElements());
    }

    public function testTerminateEventDefinition(): void
    {
        $endEvent = $this->getBpmn('TerminateEvent')
            ->getEndEvent('TerminateEvent');

        $this->assertTrue($endEvent->hasTerminateEventDefinition());
        $this->assertInstanceOf(TerminateEventDefinition::class, $endEvent->getTerminateEventDefinition()->get(0));
    }

    public function testCamundaConnector(): void
    {
        /** @var ExtensionElements $extensionElements */
        $extensionElements = $this->bpmn->getById('ServiceTask2')
            ->getExtensionElements();

        $this->assertTrue($extensionElements->hasConnector());
        $this->assertInstanceOf(Connector::class, $extensionElements->getConnector());

        /** @var Connector $connector */
        $connector = $extensionElements->getConnector();

        $this->assertSame('Scopeli\FlowBundle\Resources\Connector\DummyConnector', $connector->getConnectorId());

        $this->assertTrue($connector->hasInputOutput());
        $this->assertInstanceOf(InputOutput::class, $connector->getInputOutput());
    }

    public function testCamundaInputOutput(): void
    {
        /** @var ExtensionElements $extensionElements */
        $extensionElements = $this->bpmn->getById('ServiceTask2')
            ->getExtensionElements();

        $this->assertTrue($extensionElements->hasInputOutput());
        $this->assertInstanceOf(InputOutput::class, $extensionElements->getInputOutput());

        /** @var InputOutput $inputOutput */
        $inputOutput = $extensionElements->getInputOutput();

        $this->assertTrue($inputOutput->hasInputParameter());
        $this->assertTrue($inputOutput->hasOutputParameter());

        $this->assertCount(4, $inputOutput->getInputParameter());
        $this->assertCount(4, $inputOutput->getOutputParameter());
    }

    public function testCamundaUserTask(): void
    {
        $userTask = $this->bpmn->getById('UserTask2');

        $this->assertTrue($userTask->hasFormKey());
        $this->assertSame('form_key_1', $userTask->getFormKey());

        $this->assertTrue($userTask->hasAssignee());
        $this->assertSame('ROLE_USER', $userTask->getAssignee());
    }

    public function testScriptTask(): void
    {
        $scriptTask = $this->getBpmn('ScriptTaskSimple')
            ->getScriptTask('ScriptTask');

        $this->assertTrue($scriptTask->hasScript());
        $this->assertSame('{{ 2 + 3 }}', $scriptTask->getScript());

        $this->assertTrue($scriptTask->hasScriptFormat());
        $this->assertSame('twig', $scriptTask->getScriptFormat());
    }

    public function testCamundaScriptTask(): void
    {
        $scriptTask = $this->getBpmn('ScriptTaskSimple')
            ->getScriptTask('ScriptTask');

        $this->assertTrue($scriptTask->hasResultVariable());
        $this->assertSame('calcResult', $scriptTask->getResultVariable());
    }

    public function testMessage(): void
    {
        $message = $this->getBpmn('Message')
            ->getMessageByName('StartMessage');

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame('Message_0xwsxlo', $message->getId());
        //$this->assertCount(1, $message->getReferencedElement());
        //$this->assertInstanceOf(StartEvent::class, $message->getReferencedElement()->get(0)->getParent());
    }

    public function testMessageEventDefinition(): void
    {
        $startEvent = $this->getBpmn('Message')
            ->getStartEvent('MessageStartEvent');

        $this->assertTrue($startEvent->hasMessageEventDefinition());
        $this->assertInstanceOf(MessageEventDefinition::class, $startEvent->getMessageEventDefinition()->get(0));
    }
}
