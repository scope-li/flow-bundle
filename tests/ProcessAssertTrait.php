<?php

namespace Scopeli\FlowBundle;

use Scopeli\FlowBundle\Process\ProcessInstance;

trait ProcessAssertTrait
{
    private function assertProcessFlowLog(array $expected, ProcessInstance $processInstance)
    {
        $this->processFlowLogCache = array_merge($this->processFlowLogCache, $expected);

        foreach ($processInstance->getLogs() as $key => $log) {
            $this->assertSame($this->processFlowLogCache[$key]['id'], $log->getId());
            $this->assertSame($this->processFlowLogCache[$key]['data'], $log->getProcessData());
        }

        $this->assertCount(count($this->processFlowLogCache), $processInstance->getLogs());
    }

    private function assertTokens(array $expected, ProcessInstance $processInstance)
    {
        foreach ($processInstance->getTokens() as $token) {
            $this->assertArrayHasKey(
                $token->getCurrentId(),
                $expected,
                sprintf('Expected keys %s', implode(', ', array_keys($expected)))
            );
            $this->assertSame(
                $expected[$token->getCurrentId()],
                $token->getState(),
                sprintf('Element "%s"', $token->getCurrentId())
            );
        }

        $this->assertCount(count($expected), $processInstance->getTokens());
    }

    private function assertProcessInstanceStarted(ProcessInstance $processInstance)
    {
        $this->assertGreaterThan(0, $processInstance->getTokens());
        $this->assertTrue($processInstance->isStarted());
    }

    private function assertProcessInstanceEnded(ProcessInstance $processInstance)
    {
        $this->assertCount(0, $processInstance->getTokens());
        $this->assertTrue($processInstance->isEnded());
    }
}
