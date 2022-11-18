<?php

namespace Scopeli\FlowBundle\Serializer;

use Scopeli\FlowBundle\Exception\RuntimeException;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

class PhpSerializeSerializer implements SerializerInterface
{
    public function serialize(ProcessInstanceInterface $data): string
    {
        return serialize($data);
    }

    public function deserialize(string $data): ProcessInstanceInterface
    {
        $processInstance = unserialize($data);
        if (!$processInstance instanceof ProcessInstanceInterface) {
            throw new RuntimeException(sprintf('Unserialized data not og type %s.', ProcessInstanceInterface::class));
        }

        return $processInstance;
    }
}
