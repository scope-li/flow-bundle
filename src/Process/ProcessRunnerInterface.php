<?php

namespace Scopeli\FlowBundle\Process;

interface ProcessRunnerInterface
{
    /**
     * @param string|int $processDefinitionId
     */
    public function createProcessInstance($processDefinitionId): ProcessInstanceInterface;

    /**
     * @param mixed[] $processData
     */
    public function start(
        string $processInstanceId,
        ?string $startEventId = null,
        array $processData = []
    ): ProcessInstanceInterface;

    /**
     * @param mixed[] $processData
     */
    public function complete(
        string $processInstanceId,
        string $activityId,
        array $processData = []
    ): ProcessInstanceInterface;

    /**
     * @param mixed[] $processData
     */
    public function message(
        string $processInstanceId,
        string $message,
        array $processData = []
    ): ProcessInstanceInterface;
}
