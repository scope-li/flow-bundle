<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class EntryParameter extends ParameterDefinition
{
    private string $key;

    private string $value;

    private ?ParameterDefinition $definition = null;

    public function __construct(string $key, string $value, ?ParameterDefinition $definition = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->definition = $definition;
    }

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
