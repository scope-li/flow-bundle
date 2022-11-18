<?php

namespace Scopeli\FlowBundle;

use Scopeli\FlowBundle\Script\ScriptRunner;
use Scopeli\FlowBundle\Script\ScriptTwig;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

trait ScriptRunnerTrait
{
    protected function getScriptRunner(): ScriptRunner
    {
        return new ScriptRunner([new ScriptTwig(new Environment(new ArrayLoader()))]);
    }
}
