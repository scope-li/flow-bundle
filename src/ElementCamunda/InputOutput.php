<?php

namespace Scopeli\FlowBundle\ElementCamunda;

use DOMElement;
use Scopeli\FlowBundle\Element\Bpmn;
use Scopeli\FlowBundle\Element\AbstractElement;
use Scopeli\FlowBundle\ElementCamunda\Parameter\EntryParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\InputOutputParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\InputParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\ListParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\MapParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\OutputParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\ScriptParameter;
use Scopeli\FlowBundle\ElementCamunda\Parameter\ValueParameter;
use Scopeli\FlowBundle\Exception\LogicException;
use Scopeli\FlowBundle\Exception\RuntimeException;
use Scopeli\FlowBundle\Script\ScriptRunner;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class InputOutput extends AbstractElement
{
    /** @var InputParameter[] */
    protected array $inputParameter = [];

    /** @var OutputParameter[] */
    protected array $outputParameter = [];

    public function __construct(DOMElement $element, Bpmn $bpmn)
    {
        parent::__construct($element, $bpmn);

        /** @var DOMElement $childNode */
        foreach ($element->childNodes as $childNode) {
            if ('inputParameter' === $childNode->localName) {
                $inputParameter = $this->createInputOutputParameter($childNode, InputParameter::class);
                assert($inputParameter instanceof InputParameter);
                $this->inputParameter[] = $inputParameter;
            }

            if ('outputParameter' === $childNode->localName) {
                $outputParameter = $this->createInputOutputParameter($childNode, OutputParameter::class);
                assert($outputParameter instanceof OutputParameter);
                $this->outputParameter[] = $outputParameter;
            }
        }
    }

    /**
     * @return InputParameter[]
     */
    public function getInputParameter(): array
    {
        return $this->inputParameter;
    }

    public function hasInputParameter(): bool
    {
        return [] !== $this->inputParameter;
    }

    /**
     * @return OutputParameter[]
     */
    public function getOutputParameter(): array
    {
        return $this->outputParameter;
    }

    public function hasOutputParameter(): bool
    {
        return [] !== $this->outputParameter;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function handleInputParameters(ScriptRunner $scriptRunner, array $context = []): array
    {
        return $this->handleParameters($scriptRunner, $this->inputParameter, $context);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function handleOutputParameters(ScriptRunner $scriptRunner, array $context = []): array
    {
        return $this->handleParameters($scriptRunner, $this->outputParameter, $context);
    }

    /**
     * @return array<int|string, mixed>
     */
    private function handleParameters(ScriptRunner $scriptRunner, array $parameters, array $context = []): array
    {
        $buffer = [];

        foreach ($parameters as $parameter) {
            if ($parameter->getDefinition() instanceof MapParameter) {
                /** @var MapParameter $mapParameter */
                $mapParameter = $parameter->getDefinition();
                $buffer[$parameter->getName()] = [];
                foreach ($mapParameter->getEntries() as $entry) {
                    // @phpstan-ignore-next-line
                    $buffer[$parameter->getName()][$entry->getKey()] = $this->evaluateValue(
                        $entry->getValue(),
                        $context
                    );
                }
            } elseif ($parameter->getDefinition() instanceof ListParameter) {
                /** @var ListParameter $listParameter */
                $listParameter = $parameter->getDefinition();
                $buffer[$parameter->getName()] = [];
                foreach ($listParameter->getValues() as $item) {
                    // @phpstan-ignore-next-line
                    $buffer[$parameter->getName()][] = $this->evaluateValue(
                        $item->getValue(),
                        $context
                    );
                }
            } elseif ($parameter->getDefinition() instanceof ScriptParameter) {
                /** @var ScriptParameter $scriptParameter */
                $scriptParameter = $parameter->getDefinition();
                if (!is_string($scriptParameter->getValue())) {
                    throw new RuntimeException(sprintf('Inline script must be defined for "%s", because resource is not supported yet.', $parameter->getName()));
                }

                $buffer[$parameter->getName()] = $scriptRunner->run($scriptParameter->getScriptFormat(), $scriptParameter->getValue(), $context);
            } elseif (null === $parameter->getDefinition()) {
                $buffer[$parameter->getName()] = $this->evaluateValue($parameter->getValue(), $context);
            } else {
                throw new LogicException('This code should not be reached!');
            }
        }

        return $buffer;
    }

    /**
     * @return mixed
     */
    private function evaluateValue(string $value, array $values = [])
    {
        // Try to extract ${} expression.
        preg_match_all('#\$\{(.*?)\}#', $value, $matches);
        $expressions = $matches[1];

        if ([] !== $expressions) {
            if (count($expressions) > 1) {
                throw new RuntimeException(sprintf('Only string or one expression allowed, "%s" given.', $value));
            }

            $expressionLanguage = new ExpressionLanguage();
            $value = $expressionLanguage->evaluate($expressions[0], $values);
        }

        return $value;
    }

    private function createInputOutputParameter(DOMElement $element, string $class): InputOutputParameter
    {
        $parameter = null;

        foreach ($element->getElementsByTagName('map') as $map) {
            $entries = [];
            foreach ($map->getElementsByTagName('entry') as $entry) {
                $key = $entry->getAttribute('key');
                $entries[$key] = new EntryParameter($key, $entry->nodeValue);
            }

            /** @var InputOutputParameter $parameter */
            $parameter = new $class($element->getAttribute('name'), null, new MapParameter($entries));
        }

        foreach ($element->getElementsByTagName('list') as $list) {
            $values = [];
            foreach ($list->getElementsByTagName('value') as $value) {
                $values[] = new ValueParameter($value->nodeValue);
            }

            /** @var InputOutputParameter $parameter */
            $parameter = new $class($element->getAttribute('name'), null, new ListParameter($values));
        }

        /** @var DOMElement $script */
        foreach ($element->getElementsByTagName('script') as $script) {
            /** @var InputOutputParameter $parameter */
            $parameter = new $class(
                $element->getAttribute('name'),
                null,
                new ScriptParameter(
                    $script->getAttribute('scriptFormat'),
                    $script->hasAttribute('resource') ? $script->getAttribute('resource') : null,
                    $script->nodeValue
                )
            );
        }

        if (is_null($parameter)) {
            /** @var InputOutputParameter $parameter */
            $parameter = new $class($element->getAttribute('name'), $element->nodeValue);
        }

        return $parameter;
    }
}
