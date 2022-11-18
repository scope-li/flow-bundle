<?php

namespace Scopeli\FlowBundle\ElementCamunda\Parameter;

class Properties
{
    /** @var Property[] */
    protected array $values = [];

    /**
     * @param Property[] $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $value) {
            assert($value instanceof Property);
        }

        $this->values = $values;
    }

    /**
     * @return Property[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
