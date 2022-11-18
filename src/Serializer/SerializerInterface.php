<?php

namespace Scopeli\FlowBundle\Serializer;

use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

interface SerializerInterface
{
    public function serialize(ProcessInstanceInterface $data): string;

    public function deserialize(string $processInstance): ProcessInstanceInterface;
}
