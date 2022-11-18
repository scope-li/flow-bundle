<?php

namespace Scopeli\FlowBundle\Script;

interface ScriptInterface
{
    /**
     * @param mixed[] $context
     */
    public function execute(string $script, array $context): string;

    public function getType(): string;
}
