<?php

namespace Scopeli\FlowBundle\Script;

use PHPUnit\Framework\TestCase;
use Scopeli\FlowBundle\Exception\InvalidArgumentException;
use Scopeli\FlowBundle\ScriptRunnerTrait;
use stdClass;

class ScriptRunnerTest extends TestCase
{
    use ScriptRunnerTrait;

    private ScriptRunner $scriptRunner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scriptRunner = $this->getScriptRunner();
    }

    public function testOnlyScriptInterfaceAllowed(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->scriptRunner = new ScriptRunner([new stdClass()]);
    }

    public function testScriptNotsupported(): void
    {
        $this->expectException(ScriptNotSupportedException::class);

        $this->scriptRunner->run('javascript', 'console.log()', []);
    }

    /**
     * @dataProvider dataRun
     */
    public function testRun(string $expected, string $type, string $script, array $context): void
    {
        $this->assertSame($expected, $this->scriptRunner->run($type, $script, $context));
    }

    public function dataRun(): iterable
    {
        return [
            'Twig' => ['Test', 'twig', "{{ 'Test' }}", []],
        ];
    }
}
