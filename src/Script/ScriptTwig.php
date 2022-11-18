<?php

namespace Scopeli\FlowBundle\Script;

use Twig\Environment;

class ScriptTwig implements ScriptInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function execute(string $script, array $context = []): string
    {
        $template = $this->environment->createTemplate($script);

        return $template->render($context);
    }

    public function getType(): string
    {
        return 'twig';
    }
}
