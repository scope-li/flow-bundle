<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Event;

use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Symfony\Contracts\EventDispatcher\Event as ContractEvent;

abstract class AbstractEvent extends ContractEvent
{
    public function __construct(
        protected ProcessInstanceInterface $processInstance,
    ) {}

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
