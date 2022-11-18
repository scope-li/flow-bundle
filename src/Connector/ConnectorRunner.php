<?php

namespace Scopeli\FlowBundle\Connector;

use ReflectionMethod;
use Scopeli\FlowBundle\Element\Activity;
use Scopeli\FlowBundle\Element\ExtensionElements;
use RuntimeException;
use Scopeli\FlowBundle\ElementCamunda\Connector;
use Scopeli\FlowBundle\ElementCamunda\InputOutput;
use Scopeli\FlowBundle\Exception\InvalidArgumentException;
use Scopeli\FlowBundle\Process\ProcessInstanceInterface;
use Scopeli\FlowBundle\Script\ScriptRunner;

class ConnectorRunner
{
    /** @var ConnectorInterface[] */
    private array $connectorInstances = [];

    private ScriptRunner $scriptRunner;

    /**
     * @param ConnectorInterface[] $connectorInstances
     */
    public function __construct(ScriptRunner $scriptRunner, iterable $connectorInstances)
    {
        $this->scriptRunner = $scriptRunner;

        foreach ($connectorInstances as $connectorInstance) {
            if (!$connectorInstance instanceof ConnectorInterface) {
                throw new InvalidArgumentException(sprintf('All $connectorInstances must implement %s', ConnectorInterface::class));
            }

            $this->connectorInstances[] = $connectorInstance;
        }
    }

    /**
     * @return ConnectorInterface[]
     */
    public function getConnectorInstances(): array
    {
        return $this->connectorInstances;
    }

    public function run(Activity $activity, ProcessInstanceInterface $processInstance): void
    {
        if ($activity->hasExtensionElements()) {
            /** @var ExtensionElements $extensionElements */
            $extensionElements = $activity->getExtensionElements();
            if ($extensionElements->hasConnector()) {
                /** @var Connector $connector */
                $connector = $extensionElements->getConnector();
                $processData = $this->runConnector($connector, $processInstance->getProcessData());
                $processInstance->mergeProcessData($processData);
            }
        }
    }

    /**
     * @return mixed[]
     */
    private function runConnector(Connector $connector, array $processData): array
    {
        $connectorInstance = $this->getConnectorInstance($connector->getConnectorId());
        $inputOutput = $connector->getInputOutput();

        if ($inputOutput instanceof InputOutput) {
            $inputArguments = $inputOutput->handleInputParameters($this->scriptRunner, $processData);

            $result = $this->dispatch($connectorInstance, $inputArguments);

            return $inputOutput->handleOutputParameters($this->scriptRunner, $result);
        }

        return $this->dispatch($connectorInstance, []);
    }

    /**
     * @return mixed[]
     */
    private function dispatch(ConnectorInterface $connectorInstance, array $inputArguments): array
    {
        $arguments = $this->getRunArguments($connectorInstance, $inputArguments);

        $callback = [$connectorInstance, 'run'];
        if (\is_callable($callback)) {
            $result = \call_user_func_array($callback, $arguments);
            if (false === $result) {
                throw new RuntimeException(
                    sprintf('Methode call "run" on "%s" failed', \get_class($connectorInstance))
                );
            }

            if (!\is_array($result)) {
                throw new RuntimeException(
                    sprintf('The result from "run" on "%s" must be an array', \get_class($connectorInstance))
                );
            }

            return $result;
        }

        throw new RuntimeException(sprintf('Method "run" not found in "%s"', \get_class($connectorInstance)));
    }

    /**
     * @return mixed[]
     */
    private function getRunArguments(ConnectorInterface $connectorInstance, array $inputArguments): array
    {
        $buffer = [];

        $ref = new ReflectionMethod(\get_class($connectorInstance), 'run');
        foreach ($ref->getParameters() as $parameter) {
            $buffer[] = $inputArguments[$parameter->getName()] ?? $parameter->getDefaultValue();
        }

        return $buffer;
    }

    private function getConnectorInstance(string $class): ConnectorInterface
    {
        foreach ($this->connectorInstances as $connectorInstance) {
            if (\get_class($connectorInstance) === $class) {
                return $connectorInstance;
            }
        }

        throw new RuntimeException(sprintf('No connector "%s" found', $class));
    }
}
