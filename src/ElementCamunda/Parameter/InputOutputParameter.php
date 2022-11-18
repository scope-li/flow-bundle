<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

abstract class InputOutputParameter
{
    private string $name;

    private ?string $value = null;

    private ?ParameterDefinition $definition = null;

    public function __construct(
        string $name,
        ?string $value = null,
        ?ParameterDefinition $inputOutputParameterDefinition = null
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->definition = $inputOutputParameterDefinition;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getDefinition(): ?ParameterDefinition
    {
        return $this->definition;
    }
}
