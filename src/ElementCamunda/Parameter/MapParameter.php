<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class MapParameter extends ParameterDefinition
{
    /** @var EntryParameter[] */
    private array $entries = [];

    /**
     * @param EntryParameter[] $entries
     */
    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    /**
     * @return EntryParameter[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }
}
