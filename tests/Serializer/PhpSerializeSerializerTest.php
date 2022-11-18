<?php

namespace Scopeli\FlowBundle\Serializer;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\Process\ProcessInstance;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Scopeli\FlowBundle\Process\ProcessLog;
use Scopeli\FlowBundle\Process\Token;

class PhpSerializeSerializerTest extends AbstractSerializerTest
{
    public function testPhpSerializeSerializer(): void
    {
        $serializer = new PhpSerializeSerializer();

        $newProcessInstance =  $serializer->deserialize($serializer->serialize($this->processInstance));

        $this->assertProcessInstanceSame($this->processInstance, $newProcessInstance);
    }
}
