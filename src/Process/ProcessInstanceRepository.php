<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Process;

class ProcessInstanceRepository implements ProcessInstanceRepositoryInterface
{
    /** @var ProcessInstanceInterface[] */
    private array $storage = [];

    public function saveProcessInstance(ProcessInstanceInterface $processInstance): void
    {
        $this->storage[$processInstance->getId()] = $processInstance;
    }

    public function addProcessInstance(ProcessInstanceInterface $processInstance): void
    {
        $this->storage[$processInstance->getId()] = $processInstance;
    }

    public function findProcessInstance(string $id): ?ProcessInstanceInterface
    {
        return $this->storage[$id] ?? null;
    }
}
