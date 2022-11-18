<?php

namespace Scopeli\FlowBundle\Event;

use Scopeli\FlowBundle\Element\Activity;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

class ActivityEvent extends AbstractEvent
{
    protected Activity $activity;

    public function __construct(ProcessInstanceInterface $processInstance, Activity $activity)
    {
        parent::__construct($processInstance);

        $this->activity = $activity;
    }

    public function getActivity(): Activity
    {
        return $this->activity;
    }
}
