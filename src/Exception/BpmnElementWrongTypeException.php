<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;

class BpmnElementWrongTypeException extends LogicException
{
    public function __construct(string $id, string $name)
    {
        parent::__construct(sprintf('BPMN-Element with id "%s" has not type "%s".', $id, $name));
    }
}
