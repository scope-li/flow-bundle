<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class ScriptParameter extends ParameterDefinition
{
    private string $scriptFormat;

    private ?string $resource = null;

    private ?string $value = null;

    public function __construct(string $scriptFormat, ?string $resource = null, ?string $value = null)
    {
        $this->scriptFormat = $scriptFormat;
        $this->resource = $resource;
        $this->value = $value;
    }

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
