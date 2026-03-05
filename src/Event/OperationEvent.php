<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Event;

use Scopeli\FlowBundle\Element\Activity;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

class OperationEvent extends AbstractEvent
{
    public function __construct(ProcessInstanceInterface $processInstance, protected Activity $activity)
    {
        parent::__construct($processInstance);
    }

    public function getActivity(): Activity
    {
        return $this->activity;
    }
}
