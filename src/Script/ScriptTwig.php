<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Script;

use Twig\Environment;

class ScriptTwig implements ScriptInterface
{
    public function __construct(private readonly Environment $environment) {}

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
