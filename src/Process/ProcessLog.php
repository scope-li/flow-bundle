<?php

namespace Scopeli\FlowBundle\Process;

use DateTime;
use DateTimeInterface;

class ProcessLog implements ProcessLogInterface
{
    private string $id;

    /** @var mixed[] */
    private array $processData = [];

    private DateTimeInterface $date;

    /**
     * @param mixed[] $processData
     */
    public function __construct(string $id, array $processData)
    {
        $this->id = $id;
        $this->processData = $processData;
        $this->date = new DateTime();
    }

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'processData' => $this->processData,
            'date' => $this->date->format(DateTime::RFC3339),
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->processData = $data['processData'];
        $this->date = new DateTime($data['date']);
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed[]
     */
    public function getProcessData(): array
    {
        return $this->processData;
    }

    /**
     * @param mixed[] $processData
     */
    public function setProcessData(array $processData): self
    {
        $this->processData = $processData;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}
