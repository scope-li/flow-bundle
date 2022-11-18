<?php

namespace Scopeli\FlowBundle\Connector;

use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\Process\ProcessInstance;
use Scopeli\FlowBundle\ProcessDataTrait;
use Scopeli\FlowBundle\ProcessDefinitionRepositoryTrait;
use Scopeli\FlowBundle\Resources\Connector\DummyConnector;
use Scopeli\FlowBundle\ScriptRunnerTrait;

class ConnectorRunnerTest extends TestCase
{
    use ProcessDefinitionRepositoryTrait;
    use ProcessDataTrait;
    use ScriptRunnerTrait;

    private ConnectorRunner $connectorRunner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connectorRunner = new ConnectorRunner($this->getScriptRunner(), [
            new DummyConnector()
        ]);
    }

    public function testInputOutputParameter()
    {
        $bpmn = $this->getBpmnString('AllElementCamunda');
        $processInstance = new ProcessInstance($bpmn, $this->dataSet1);
        $serviceTask = $processInstance->getBpmn()->getServiceTask('ServiceTask1');

        $this->connectorRunner->run($serviceTask, $processInstance);

        $this->assertSame(
            array_merge(
                $this->dataSet1,
                [
                    'var4' => [
                        'key1' => false,
                        'key2' => 'flow',
                    ],
                    'var3' => ['www', 'zzz'],
                    'var2' => 'Harry code',
                    'var1' => 50
                ]
            ),
            $processInstance->getProcessData()
        );
    }
}
