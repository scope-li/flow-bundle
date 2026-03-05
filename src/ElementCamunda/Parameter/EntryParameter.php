<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class EntryParameter extends ParameterDefinition
{
    public function __construct(private readonly string $key, private readonly string $value, private readonly ?ParameterDefinition $definition = null) {}

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDefinition(): ?ParameterDefinition
    {
        return $this->definition;
    }
}
