<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Process;

interface ProcessInstanceRepositoryInterface
{
    public function addProcessInstance(ProcessInstanceInterface $processInstance): void;

    public function saveProcessInstance(ProcessInstanceInterface $processInstance): void;

    public function findProcessInstance(string $id): ?ProcessInstanceInterface;
}
