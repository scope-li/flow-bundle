<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Process;

interface ProcessDefinitionRepositoryInterface
{
    /**
     * @param string|int $id
     */
    public function findProcessDefinition($id): ?string;
}
