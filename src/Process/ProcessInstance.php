<?php

namespace Scopeli\FlowBundle\Process;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Scopeli\FlowBundle\Element\Bpmn;
use Scopeli\FlowBundle\Element\ElementList;
use Scopeli\FlowBundle\Element\FlowElement;
use Scopeli\FlowBundle\Exception\LogicException;

class ProcessInstance implements ProcessInstanceInterface
{
    private string $id;

    private Bpmn $bpmn;

    /** @var mixed[] */
    private array $processData = [];

    /** @var TokenInterface[] */
    private array $tokens = [];

    private ?string $state = null;

    private ?DateTimeInterface $startDate = null;

    private ?DateTimeInterface $endDate = null;

    /** @var ProcessLogInterface[] */
    private array $logs = [];

    /**
     * @param mixed[] $processData
     */
    public function __construct(string $bpmn, array $processData = [])
    {
        $this->id = (string) Uuid::uuid4();
        $this->bpmn = $this->createBpmn($bpmn);
        $this->processData = $processData;
    }

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'bpmn' => $this->bpmn->saveXML(),
            'processData' => $this->processData,
            'state' => $this->state,
            'startDate' => $this->startDate instanceof DateTimeInterface ? $this->startDate->format(DateTime::RFC3339) : null,
            'endDate' => $this->endDate instanceof DateTimeInterface ? $this->endDate->format(DateTime::RFC3339) : null,
            'tokens' => $this->tokens,
            'logs' => $this->logs,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->bpmn = $this->createBpmn($data['bpmn']);
        $this->id = $data['id'];
        $this->processData = $data['processData'];
        $this->state = $data['state'];
        $this->startDate = $data['startDate'] !== null ? new DateTime($data['startDate']) : null;
        $this->endDate = $data['endDate'] !== null ? new DateTime($data['endDate']) : null;
        $this->tokens = $data['tokens'];
        $this->logs = $data['logs'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBpmn(): Bpmn
    {
        return $this->bpmn;
    }

    /** @return mixed[] */
    public function getProcessData(): array
    {
        return $this->processData;
    }

    /** @param mixed[] $processData */
    public function setProcessData(array $processData): ProcessInstance
    {
        $this->processData = $processData;

        return $this;
    }

    public function mergeProcessData(array $processData): ProcessInstance
    {
        $this->processData = array_merge($this->processData, $processData);

        return $this;
    }

    /** @return TokenInterface[] */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    /** @return ProcessLogInterface[] */
    public function getLogs(): array
    {
        return $this->logs;
    }

    public function isStarted(): bool
    {
        return $this->state === self::STATE_STARTED;
    }

    public function isEnded(): bool
    {
        return $this->state === self::STATE_ENDED;
    }

    public function isCancelled(): bool
    {
        return $this->state === self::STATE_CANCELLED;
    }

    public function isError(): bool
    {
        return $this->state === self::STATE_ERROR;
    }

    public function isAbnormal(): bool
    {
        return $this->state === self::STATE_ABNORMAL;
    }

    public function setStarted(): void
    {
        $this->state = self::STATE_STARTED;
        $this->startDate = new DateTime();
    }

    public function setEnded(): void
    {
        $this->state = ProcessInstance::STATE_ENDED;
        $this->endDate = new DateTime();
    }

    public function setCancelled(): void
    {
        $this->state = ProcessInstance::STATE_CANCELLED;
    }

    public function setError(): void
    {
        $this->state = ProcessInstance::STATE_ERROR;
    }

    public function setAbnormal(): void
    {
        $this->state = ProcessInstance::STATE_ABNORMAL;
    }

    public function findTokenByCurrentId(string $currentId): TokenInterface
    {
        foreach ($this->tokens as $token) {
            if ($currentId === $token->getCurrentId()) {
                return $token;
            }
        }

        throw new LogicException(sprintf('No token for currentId "%s" found.', $currentId));
    }

    /** @return TokenInterface[] */
    public function findTokenById(string $id): array
    {
        return array_filter($this->tokens, fn (TokenInterface $token): bool => $token->getId() === $id);
    }

    /** @return TokenInterface[] */
    public function findTokenByState(array $states): array
    {
        return array_filter($this->tokens, fn (TokenInterface $token): bool => in_array($token->getState(), $states));
    }

    public function createToken(string $currentId): TokenInterface
    {
        $token = new Token($currentId);
        $this->tokens[] = $token;

        return $token;
    }

    public function cloneToken(TokenInterface $currentToken, string $currentId): TokenInterface
    {
        $token = clone $currentToken;
        $token->setInactive();
        $token->flow($currentId);

        $this->tokens[] = $token;

        return $token;
    }

    public function removeToken(TokenInterface $removeToken, bool $addLog = true): void
    {
        foreach ($this->tokens as $key => $token) {
            if ($token === $removeToken) {
                unset($this->tokens[$key]);
                if ($addLog) {
                    $this->createLog($token->getCurrentId());
                }
            }
        }
    }

    public function flowToken(TokenInterface $currentToken, string $targetId): TokenInterface
    {
        // If a token with the same id wait on the target, remove the next one (reduce the token count to the one that waiting).
        foreach ($this->tokens as $token) {
            if ($token->getId() === $currentToken->getId() && $token->getCurrentId() === $targetId) {
                $this->removeToken($currentToken);

                return $token;
            }
        }

        $this->createLog($currentToken->getCurrentId());
        $currentToken->flow($targetId);

        return $currentToken;
    }

    public function hasTokenByState(array $states): bool
    {
        return [] !== $this->findTokenByState($states);
    }

    /** @return ElementList<FlowElement> */
    public function getTokenElements(): ElementList
    {
        $buffer = [];
        foreach ($this->tokens as $token) {
            $buffer[] = $this->getBpmn()->getFlowElementById($token->getCurrentId());
        }

        return new ElementList($buffer);
    }

    public function getFirstTokenElement(): ?FlowElement
    {
        $tokenElements = $this->getTokenElements();
        if ($tokenElements->hasElements()) {
            return $tokenElements->get(0);
        }

        return null;
    }

    private function createBpmn(string $bpmnContent): Bpmn
    {
        $bpmn = new Bpmn();
        $bpmn->loadXML($bpmnContent, \LIBXML_NOBLANKS);

        return $bpmn;
    }

    private function createLog(string $currentId): void
    {
        $this->logs[] = new ProcessLog($currentId, $this->processData);
    }
}
