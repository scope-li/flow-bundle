<?php

namespace Scopeli\FlowBundle\Serializer;

use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

interface ProcessInstanceSerializableInterface
{
    public function setProcessInstanceSerialized(?string $serializedProcessInstance): self;

    public function getProcessInstanceSerialized(): ?string;

    public function getProcessInstance(): ?ProcessInstanceInterface;

    public function setProcessInstance(?ProcessInstanceInterface $processInstance): self;
}
