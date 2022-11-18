<?php

namespace Scopeli\FlowBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Scopeli\FlowBundle\Serializer\ProcessInstanceSerializableInterface;
use Scopeli\FlowBundle\Serializer\SerializerInterface;

class DoctrineListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $this->serializeProcessInstance($eventArgs);
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->serializeProcessInstance($eventArgs);
    }

    public function postLoad(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof ProcessInstanceSerializableInterface && \is_string($entity->getProcessInstanceSerialized())) {
            $processInstance = $this->serializer->deserialize($entity->getProcessInstanceSerialized());

            $entity->setProcessInstance($processInstance);
        }
    }

    private function serializeProcessInstance(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof ProcessInstanceSerializableInterface && $entity->getProcessInstance() instanceof ProcessInstanceInterface) {
            $entity->setProcessInstanceSerialized($this->serializer->serialize($entity->getProcessInstance()));
        }
    }
}
