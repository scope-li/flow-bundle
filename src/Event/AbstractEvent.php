<?php

namespace Scopeli\FlowBundle\Event;

use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Symfony\Contracts\EventDispatcher\Event as ContractEvent;

abstract class AbstractEvent extends ContractEvent
{
    protected ProcessInstanceInterface $processInstance;

    public function __construct(ProcessInstanceInterface $processInstance)
    {
        $this->processInstance = $processInstance;
    }

    public function getProcessInstance(): ProcessInstanceInterface
    {
        return $this->processInstance;
    }

    /**
     * @return mixed[]
     */
    public function getProcessData(): array
    {
        return $this->processInstance->getProcessData();
    }

    /**
     * @param mixed[] $processData
     */
    public function setProcessData(array $processData): void
    {
        $this->processInstance->setProcessData($processData);
    }
}
