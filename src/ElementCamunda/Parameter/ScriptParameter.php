<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ScriptParameter extends ParameterDefinition
{
    public function __construct(private readonly string $scriptFormat, private readonly ?string $resource = null, private readonly ?string $value = null) {}

    public function getScriptFormat(): string
    {
        return $this->scriptFormat;
    }

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
