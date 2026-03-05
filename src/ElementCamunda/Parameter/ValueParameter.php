<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ValueParameter extends ParameterDefinition
{
    public function __construct(private readonly string $value, private readonly ?string $id = null, private readonly ?string $name = null) {}

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
