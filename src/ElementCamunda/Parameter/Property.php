<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class Property
{
    protected string $name;

    protected string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
