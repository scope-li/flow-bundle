<?php

namespace Scopeli\FlowBundle\Bpmn;

use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\ProcessDefinitionRepositoryTrait;

class BpmnDocumentTest extends TestCase
{
    use ProcessDefinitionRepositoryTrait;

    public function testGetUserTasks(): void
    {
        $bpmn = $this->getBpmn('MultipleUserTaskInSubProcess');

        $this->assertCount(3, $bpmn->findAllUserTask());
    }
}
