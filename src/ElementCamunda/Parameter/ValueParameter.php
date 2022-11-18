<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ValueParameter extends ParameterDefinition
{
    private string $value;

    private ?string $id = null;

    private ?string $name = null;

    public function __construct(string $value, ?string $id = null, ?string $name = null)
    {
        $this->value = $value;
        $this->id = $id;
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
