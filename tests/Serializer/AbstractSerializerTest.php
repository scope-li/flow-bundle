<?php

namespace Scopeli\FlowBundle\Serializer;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\Process\ProcessInstance;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Scopeli\FlowBundle\Process\ProcessLog;
use Scopeli\FlowBundle\Process\Token;

abstract class AbstractSerializerTest extends TestCase
{
    protected ProcessInstance $processInstance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->processInstance = new ProcessInstance('<?xml version="1.0"?><node></node>', ['key1' => 'value1']);
        $this->processInstance->setStarted();
        $this->processInstance->createToken('element1');
        $this->processInstance->findTokenByCurrentId('element1')->setClosed();
        $this->processInstance->flowToken($this->processInstance->findTokenByCurrentId('element1'), 'element2');
        $this->processInstance->findTokenByCurrentId('element2')->setClosed();
        $this->processInstance->flowToken($this->processInstance->findTokenByCurrentId('element2'), 'element3');
        $this->processInstance->findTokenByCurrentId('element3')->setReady();
        $this->processInstance->cloneToken($this->processInstance->findTokenByCurrentId('element3'), 'element4');
        $this->processInstance->findTokenByCurrentId('element4')->setActive();
    }

    protected function assertProcessInstanceSame(ProcessInstanceInterface $processInstance1, ProcessInstanceInterface $processInstance2): void
    {
        $this->assertSame($processInstance1->getId(), $processInstance2->getId());
        $this->assertSame($processInstance1->getBpmn()->saveXML(), $processInstance2->getBpmn()->saveXML());
        $this->assertSame($processInstance1->getProcessData(), $processInstance2->getProcessData());
        $this->assertSame($processInstance1->getState(), $processInstance2->getState());
        $this->assertSame(
            $processInstance1->getStartDate()->format(DateTime::RFC3339),
            $processInstance2->getStartDate()->format(DateTime::RFC3339)
        );
        if ($processInstance1->getEndDate() instanceof DateTimeInterface) {
            $this->assertSame(
                $processInstance1->getStartDate()->format(DateTime::RFC3339),
                $processInstance2->getStartDate()->format(DateTime::RFC3339)
            );
        } else {
            $this->assertNull($processInstance1->getEndDate());
            $this->assertNull($processInstance2->getEndDate());
        }
        $this->assertSameSize($processInstance1->getLogs(), $processInstance2->getLogs());
        foreach ($processInstance1->getLogs() as $key => $log) {
            $this->assertArrayHasKey($key, $processInstance2->getLogs());
            $this->assertSame($log->getId(), $processInstance2->getLogs()[$key]->getId());
            $this->assertSame($log->getProcessData(), $processInstance2->getLogs()[$key]->getProcessData());
            $this->assertSame(
                $log->getDate()->format(DateTime::RFC3339),
                $processInstance2->getLogs()[$key]->getDate()->format(DateTime::RFC3339)
            );
        }
        $this->assertSameSize($processInstance1->getTokens(), $processInstance2->getTokens());
        foreach ($processInstance1->getTokens() as $key => $token) {
            $this->assertArrayHasKey($key, $processInstance2->getTokens());
            $this->assertSame($token->getId(), $processInstance2->getTokens()[$key]->getId());
            $this->assertSame($token->getCurrentId(), $processInstance2->getTokens()[$key]->getCurrentId());
            $this->assertSame($token->getState(), $processInstance2->getTokens()[$key]->getState());
        }
    }
}
