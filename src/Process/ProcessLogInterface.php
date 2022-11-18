<?php

namespace Scopeli\FlowBundle\Process;

use DateTimeInterface;

interface ProcessLogInterface
{
    public function __serialize(): array;

    public function __unserialize(array $data): void;

    public function getId(): string;

    /**
     * @return mixed[]
     */
    public function getProcessData(): array;

    /**
     * @param mixed[] $processData
     */
    public function setProcessData(array $processData): self;

    public function getDate(): DateTimeInterface;
}
