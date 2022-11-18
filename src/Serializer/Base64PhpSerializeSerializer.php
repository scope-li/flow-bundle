<?php

namespace Scopeli\FlowBundle\Serializer;

use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

class Base64PhpSerializeSerializer extends PhpSerializeSerializer
{
    public function serialize(ProcessInstanceInterface $data): string
    {
        return base64_encode(parent::serialize($data));
    }

    public function deserialize(string $data): ProcessInstanceInterface
    {
        return parent::deserialize(base64_decode($data));
    }
}
