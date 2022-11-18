<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ListParameter extends ParameterDefinition
{
    /** @var ValueParameter[] */
    private array $values = [];

    /**
     * @param ValueParameter[] $items
     */
    public function __construct(array $items)
    {
        $this->values = $items;
    }

    /**
     * @return ValueParameter[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
