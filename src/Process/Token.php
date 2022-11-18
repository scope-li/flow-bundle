<?php

namespace Scopeli\FlowBundle\Process;

use Ramsey\Uuid\Uuid;

class Token implements TokenInterface
{
    private string $id;

    private string $currentId;

    private ?string $previousId = null;

    private string $state;

    public function __construct(string $currentId)
    {
        $this->id = (string)Uuid::uuid4();
        $this->currentId = $currentId;
        $this->setInactive();
    }

    /**
     * @return array<string, string>
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'currentId' => $this->currentId,
            'state' => $this->state,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->currentId = $data['currentId'];
        $this->state = $data['state'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrentId(): string
    {
        return $this->currentId;
    }

    public function getPreviousId(): ?string
    {
        return $this->previousId;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setInactive(): self
    {
        $this->state = self::STATE_INACTIVE;

        return $this;
    }

    public function setReady(): self
    {
        $this->state = self::STATE_READY;

        return $this;
    }

    public function setActive(): self
    {
        $this->state = self::STATE_ACTIVE;

        return $this;
    }

    public function setCompleting(): self
    {
        $this->state = self::STATE_COMPLETING;

        return $this;
    }

    public function setCompleted(): self
    {
        $this->state = self::STATE_COMPLETED;

        return $this;
    }

    public function setClosed(): self
    {
        $this->state = self::STATE_CLOSED;

        return $this;
    }

    public function isInactive(): bool
    {
        return $this->state === self::STATE_INACTIVE;
    }

    public function isReady(): bool
    {
        return $this->state === self::STATE_READY;
    }

    public function isActive(): bool
    {
        return $this->state === self::STATE_ACTIVE;
    }

    public function isCompleting(): bool
    {
        return $this->state === self::STATE_COMPLETING;
    }

    public function isCompleted(): bool
    {
        return $this->state === self::STATE_COMPLETED;
    }

    public function isClosed(): bool
    {
        return $this->state === self::STATE_CLOSED;
    }

    public function flow(string $targetId): void
    {
        $this->previousId = $this->currentId;
        $this->currentId = $targetId;
        $this->setInactive();
    }
}
