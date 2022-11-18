<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;

class ProcessInstanceNotFoundException extends LogicException
{
    public function __construct(string $processInstanceId)
    {
        parent::__construct(sprintf('No process instance with id "%s" found.', $processInstanceId));
    }
}
