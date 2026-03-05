<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Serializer;

use Override;
use Scopeli\FlowBundle\Exception\RuntimeException;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;

class Base64PhpSerializeSerializer extends PhpSerializeSerializer
{
    #[Override]
    public function serialize(ProcessInstanceInterface $data): string
    {
        return base64_encode(parent::serialize($data));
    }

    #[Override]
    public function deserialize(string $data): ProcessInstanceInterface
    {
        $decoded = base64_decode($data, true);

        if ($decoded === false) {
            throw new RuntimeException('Failed to decode base64 data.');
        }

        return parent::deserialize($decoded);
    }
}
