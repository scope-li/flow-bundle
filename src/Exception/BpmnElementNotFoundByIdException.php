<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;

class BpmnElementNotFoundByIdException extends LogicException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('BPMN-Element with id "%s" has not found.', $id));
    }
}
