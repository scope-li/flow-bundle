<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ListParameter extends ParameterDefinition
{
    /**
     * @param ValueParameter[] $values
     */
    public function __construct(private readonly array $values) {}

    /**
     * @return ValueParameter[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
