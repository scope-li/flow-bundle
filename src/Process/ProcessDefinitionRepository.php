<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Process;

class ProcessDefinitionRepository implements ProcessDefinitionRepositoryInterface
{
    /**
     * @param string[] $definition
     */
    public function __construct(private array $definition) {}

    /**
     * {@inheritDoc}
     */
    public function findProcessDefinition($id): ?string
    {
        return $this->definition[$id] ?? null;
    }
}
