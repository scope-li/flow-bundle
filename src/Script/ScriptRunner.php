<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Script;

use Scopeli\FlowBundle\Exception\InvalidArgumentException;

class ScriptRunner
{
    /** @var array<string, ScriptInterface> */
    private readonly array $scripts;

    /**
     * @param ScriptInterface[] $scripts
     */
    public function __construct(iterable $scripts)
    {
        $validated = [];
        foreach ($scripts as $script) {
            if (!$script instanceof ScriptInterface) {
                throw new InvalidArgumentException(sprintf('All $scripts must implement %s', ScriptInterface::class));
            }

            $validated[strtolower($script->getType())] = $script;
        }

        $this->scripts = $validated;
    }

    public function run(string $type, string $script, array $context): string
    {
        $type = strtolower($type);

        if (!isset($this->scripts[$type])) {
            throw new ScriptNotSupportedException($type);
        }

        return $this->scripts[$type]->execute($script, $context);
    }
}
