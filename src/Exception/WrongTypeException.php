<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;

class WrongTypeException extends LogicException
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Is not a type of "%s".', $type));
    }
}
