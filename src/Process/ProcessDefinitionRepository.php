<?php

namespace Scopeli\FlowBundle\Process;

class ProcessDefinitionRepository implements ProcessDefinitionRepositoryInterface
{
    /** @var string[] */
    private array $definition = [];

    /**
     * @param string[] $definition
     */
    public function __construct(array $definition)
    {
        $this->definition = $definition;
    }

    /**
     * {@inheritDoc}
     */
    public function findProcessDefinition($id): ?string
    {
        if (isset($this->definition[$id])) {
            return $this->definition[$id];
        }

        return null;
    }
}
