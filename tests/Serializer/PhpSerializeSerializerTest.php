<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Serializer;

class PhpSerializeSerializerTest extends AbstractSerializerTest
{
    public function testPhpSerializeSerializer(): void
    {
        $serializer = new PhpSerializeSerializer();

        $newProcessInstance =  $serializer->deserialize($serializer->serialize($this->processInstance));

        $this->assertProcessInstanceSame($this->processInstance, $newProcessInstance);
    }
}
