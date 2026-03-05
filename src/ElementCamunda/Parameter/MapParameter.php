<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class MapParameter extends ParameterDefinition
{
    /**
     * @param EntryParameter[] $entries
     */
    public function __construct(private readonly array $entries) {}

    /**
     * @return EntryParameter[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }
}
