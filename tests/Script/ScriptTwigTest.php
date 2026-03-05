<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Script;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class ScriptTwigTest extends TestCase
{
    private ScriptTwig $scriptTwig;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scriptTwig = new ScriptTwig(new Environment(new ArrayLoader()));
    }

    #[DataProvider('dataExecute')]
    public function testExecute(string $expected, string $script, array $context): void
    {
        $this->assertSame($expected, $this->scriptTwig->execute($script, $context));
    }

    public static function dataExecute(): iterable
    {
        return [
            'String rendering' => ['Test', "{{ 'Test' }}", []],
            'Calculation' => ['5', '{{ 2 + 3 }}', []],
        ];
    }
}
