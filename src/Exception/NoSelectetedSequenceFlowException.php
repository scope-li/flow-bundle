<?php

namespace Scopeli\FlowBundle\Exception;

use LogicException;
use Throwable;

class NoSelectetedSequenceFlowException extends LogicException
{
    public function __construct(string $id, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('No SequenceFlow can selected for "%s".', $id), $code, $previous);
    }
}
