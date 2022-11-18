<?php

namespace Scopeli\FlowBundle\Script;

use Scopeli\FlowBundle\Exception\RuntimeException;

class ScriptNotSupportedException extends RuntimeException
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Script "%s" not sopported (no handler found).', $type));
    }
}
