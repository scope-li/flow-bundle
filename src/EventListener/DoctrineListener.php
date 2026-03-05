<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\ObjectManager;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Scopeli\FlowBundle\Serializer\ProcessInstanceSerializableInterface;
use Scopeli\FlowBundle\Serializer\SerializerInterface;

class DoctrineListener
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    /**
     * @param LifecycleEventArgs<ObjectManager> $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $this->serializeProcessInstance($eventArgs);
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->serializeProcessInstance($eventArgs);
    }

    /**
     * @param LifecycleEventArgs<ObjectManager> $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof ProcessInstanceSerializableInterface && \is_string($entity->getProcessInstanceSerialized())) {
            $processInstance = $this->serializer->deserialize($entity->getProcessInstanceSerialized());

            $entity->setProcessInstance($processInstance);
        }
    }

    /**
     * @param LifecycleEventArgs<ObjectManager> $eventArgs
     */
    private function serializeProcessInstance(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof ProcessInstanceSerializableInterface && $entity->getProcessInstance() instanceof ProcessInstanceInterface) {
            $entity->setProcessInstanceSerialized($this->serializer->serialize($entity->getProcessInstance()));
        }
    }
}
