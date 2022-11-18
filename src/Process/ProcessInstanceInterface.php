<?php

namespace Scopeli\FlowBundle\Process;

use DateTimeInterface;
use Scopeli\FlowBundle\Element\Bpmn;
use Scopeli\FlowBundle\Element\ElementList;
use Scopeli\FlowBundle\Element\FlowElement;

interface ProcessInstanceInterface
{
    /**
     * @var string
     */
    public const STATE_STARTED = 'started';

    /**
     * @var string
     */
    public const STATE_ENDED = 'ended';

    /**
     * @var string
     */
    public const STATE_CANCELLED = 'cancelled';

    /**
     * @var string
     */
    public const STATE_ERROR = 'error';

    /**
     * @var string
     */
    public const STATE_ABNORMAL = 'abnormal';

    public function __serialize(): array;

    public function __unserialize(array $data): void;

    public function getId(): string;

    public function getBpmn(): Bpmn;

    /** @return mixed[] */
    public function getProcessData(): array;

    /**
     * @param mixed[] $processData
     */
    public function setProcessData(array $processData): ProcessInstance;

    public function mergeProcessData(array $processData): ProcessInstance;

    /**
     * @return TokenInterface[]
     */
    public function getTokens(): array;

    public function getState(): ?string;

    public function getStartDate(): ?DateTimeInterface;

    public function getEndDate(): ?DateTimeInterface;

    /** @return ProcessLogInterface[] */
    public function getLogs(): array;

    public function isStarted(): bool;

    public function isEnded(): bool;

    public function isCancelled(): bool;

    public function isError(): bool;

    public function isAbnormal(): bool;

    public function setStarted(): void;

    public function setEnded(): void;

    public function setCancelled(): void;

    public function setError(): void;

    public function setAbnormal(): void;

    public function findTokenByCurrentId(string $currentId): TokenInterface;

    /** @return TokenInterface[] */
    public function findTokenById(string $groupId): array;

    /** @return TokenInterface[] */
    public function findTokenByState(array $states): array;

    public function createToken(string $currentId): TokenInterface;

    public function cloneToken(TokenInterface $token, string $currentId): TokenInterface;

    public function removeToken(TokenInterface $token, bool $addLog = true): void;

    public function flowToken(TokenInterface $currentCurrentToken, string $targetId): TokenInterface;

    public function hasTokenByState(array $states): bool;

    /** @return ElementList<FlowElement> */
    public function getTokenElements(): ElementList;

    public function getFirstTokenElement(): ?FlowElement;
}
