<?php

namespace Scopeli\FlowBundle\Script;

use Scopeli\FlowBundle\Exception\InvalidArgumentException;

class ScriptRunner
{
    /** @var ScriptInterface[] */
    private array $scripts = [];

    /**
     * @param ScriptInterface[] $scripts
     */
    public function __construct(iterable $scripts)
    {
        foreach ($scripts as $script) {
            if (!$script instanceof ScriptInterface) {
                throw new InvalidArgumentException(sprintf('All $scripts must implement %s', ScriptInterface::class));
            }

            $this->scripts[strtolower($script->getType())] = $script;
        }
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
