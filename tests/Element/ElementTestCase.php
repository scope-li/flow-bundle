<?php

namespace Scopeli\FlowBundle\Element;

use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\ProcessDefinitionRepositoryTrait;

abstract class ElementTestCase extends TestCase
{
    use ProcessDefinitionRepositoryTrait;

    protected Bpmn $bpmn;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bpmn = $this->getBpmn('AllElement');
    }
}
