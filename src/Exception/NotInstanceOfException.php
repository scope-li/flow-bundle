<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;

class NotInstanceOfException extends LogicException
{
    public function __construct(string $className, string $expected)
    {
        parent::__construct(sprintf('"%s "is not an instance of "%s".', $className, $expected));
    }
}
