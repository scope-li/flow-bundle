<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

abstract class InputOutputParameter
{
    public function __construct(private readonly string $name, private readonly ?string $value = null, private readonly ?ParameterDefinition $definition = null) {}

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
