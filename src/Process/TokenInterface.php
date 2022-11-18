<?php

namespace Scopeli\FlowBundle\Process;

interface TokenInterface
{
    /**
     * @var string
     */
    public const STATE_INACTIVE = 'inactive';

    /**
     * @var string
     */
    public const STATE_READY = 'ready';

    /**
     * @var string
     */
    public const STATE_ACTIVE = 'active';

    /**
     * @var string
     */
    public const STATE_COMPLETING = 'completing';

    /**
     * @var string
     */
    public const STATE_COMPLETED = 'completed';

    /**
     * @var string
     */
    public const STATE_CLOSED = 'closed';

    public function __serialize(): array;

    public function __unserialize(array $data): void;

    public function getId(): string;

    public function getCurrentId(): string;

    public function getPreviousId(): ?string;

    public function getState(): string;

    public function setInactive(): self;

    public function setReady(): self;

    public function setActive(): self;

    public function setCompleting(): self;

    public function setCompleted(): self;

    public function setClosed(): self;

    public function isInactive(): bool;

    public function isReady(): bool;

    public function isActive(): bool;

    public function isCompleting(): bool;

    public function isCompleted(): bool;

    public function isClosed(): bool;

    public function flow(string $targetId): void;
}
