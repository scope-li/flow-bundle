<?php

namespace Scopeli\FlowBundle\Command;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Scopeli\FlowBundle\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClassCommand extends Command
{
    /** @var string */
    private const XSD = 'src/Resources/schema/Semantic.xsd';

    /** @var string */
    private const OUTPUT = 'src/Element';

    /** @var string */
    private const NAMESPACE = 'Scopeli\FlowBundle\Element';

    /** @var array */
    private const CAMUNDA_EXTENSION = [
        'extensionElements' => [
            'useClasses' => [
                'Scopeli\FlowBundle\ElementCamunda\Connector',
                'Scopeli\FlowBundle\ElementCamunda\InputOutput',
            ],
            'functions' => [
                [
                    'kind' => 'element',
                    'name' => 'connector',
                    'functionName' => 'Connector',
                    'returnType' => [
                        'type' => 'Connector',
                        'nullable' => true,
                        'list' => false,
                        'simpleType' => false,
                        'ref' => false,
                    ],
                ],
                [
                    'kind' => 'element',
                    'name' => 'inputOutput',
                    'functionName' => 'InputOutput',
                    'returnType' => [
                        'type' => 'InputOutput',
                        'nullable' => true,
                        'list' => false,
                        'simpleType' => false,
                        'ref' => false,
                    ],
                ],
            ],
        ],
        'scriptTask' => [
            'useClasses' => [],
            'functions' => [
                [
                    'kind' => 'attribute',
                    'name' => 'resultVariable',
                    'functionName' => 'ResultVariable',
                    'returnType' => [
                        'type' => 'string',
                        'nullable' => true,
                        'list' => false,
                        'simpleType' => false,
                        'ref' => false,
                    ],
                ],
            ],
        ],
        'userTask' => [
            'useClasses' => [],
            'functions' => [
                [
                    'kind' => 'attribute',
                    'name' => 'formKey',
                    'functionName' => 'FormKey',
                    'returnType' => [
                        'type' => 'string',
                        'nullable' => true,
                        'list' => false,
                        'simpleType' => false,
                        'ref' => false,
                    ],
                ],
                [
                    'kind' => 'attribute',
                    'name' => 'assignee',
                    'functionName' => 'Assignee',
                    'returnType' => [
                        'type' => 'string',
                        'nullable' => true,
                        'list' => false,
                        'simpleType' => false,
                        'ref' => false,
                    ],
                ],
            ],
        ],
    ];

    protected static $defaultName = 'create:class';

    private DOMDocument $xsd;

    private array $classes = [];

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->xsd = new DOMDocument();
        $this->xsd->load($this->getXsdPath());
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->readXsdToClassArray();
        $this->cleanup();
        $this->createBpmnClass();
        $this->createElementClasses();

        return Command::SUCCESS;
    }

    private function readXsdToClassArray(): void
    {
        $elements = $this->query('/xsd:schema/xsd:element');

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            $elementName = $element->getAttribute('name');
            $elementType = $element->getAttribute('type');
            /** @var DOMElement $complexType */
            $complexType = $this->query(
                sprintf('/xsd:schema/xsd:complexType[@name="%s"]', $elementType)
            )->item(0);
            $extension = $complexType->getElementsByTagName('extension');

            $extends = 'AbstractElement';
            if ($extension->length > 0) {
                /** @var DOMElement $extensionElement */
                $extensionElement = $extension->item(0);
                $extends = substr($extensionElement->getAttribute('base'), 1);
            }

            $functions = [];
            /** @var DOMElement $complexTypeElement */
            foreach ($complexType->getElementsByTagName('element') as $complexTypeElement) {
                if ($complexTypeElement->hasAttribute('ref')) {
                    $substitutionGroup = $this->query(
                        sprintf(
                            '/xsd:schema/xsd:element[@substitutionGroup="%s"]',
                            $complexTypeElement->getAttribute('ref')
                        )
                    );
                    if ($substitutionGroup->length === 0) {
                        $name = $complexTypeElement->getAttribute('ref');
                        $type = ucfirst($name);
                        if (in_array($name, ['script', 'text'])) {
                            $type = 'string';
                        }

                        $functions[$name] = [
                            'kind' => 'element',
                            'name' => $name,
                            'functionName' => ucfirst($name),
                            'returnType' => $this->getReturnType($complexTypeElement, $type),
                        ];
                    } else {
                        foreach ($substitutionGroup as $substitutionGroupItem) {
                            $name = $substitutionGroupItem->getAttribute('name');
                            $functions[$name] = [
                                'kind' => 'element',
                                'name' => $name,
                                'functionName' => ucfirst($name),
                                'returnType' => $this->getReturnType($complexTypeElement, ucfirst($name)),
                            ];
                        }
                    }
                } elseif ($complexTypeElement->hasAttribute('name')) {
                    // partitionElement with tBaseElement as type generates wrong class instance.
                    if ('partitionElement' === $complexTypeElement->getAttribute('name')) {
                        continue;
                    }

                    $name = $complexTypeElement->getAttribute('name');
                    $functions[$name] = [
                        'kind' => 'element',
                        'name' => $name,
                        'functionName' => ucfirst($name),
                        'returnType' => $this->getReturnType($complexTypeElement),
                    ];
                } else {
                    throw new RuntimeException('Not handled case.');
                }
            }

            /** @var DOMElement $complexTypeAttribute */
            foreach ($complexType->getElementsByTagName('attribute') as $complexTypeAttribute) {
                $name = $complexTypeAttribute->getAttribute('name');
                // id function is defined in AbstractElement
                if ('id' === $name) {
                    continue;
                }

                $functions[$name] = [
                    'kind' => 'attribute',
                    'name' => $name,
                    'functionName' => ucfirst($name),
                    'returnType' => $this->getReturnType($complexTypeAttribute),
                ];
            }

            // Interface is a php key word.
            if ('interface' === $elementName) {
                $elementName .= 'Element';
            }

            $this->classes[$elementName] = [
                'className' => ucfirst($elementName),
                'useClasses' => [],
                'functions' => $functions,
                'abstract' => $complexType->hasAttribute('abstract'),
                'extends' => $extends,
            ];

            if (isset(self::CAMUNDA_EXTENSION[$elementName])) {
                $this->classes[$elementName]['useClasses'] = array_merge(
                    $this->classes[$elementName]['useClasses'],
                    self::CAMUNDA_EXTENSION[$elementName]['useClasses']
                );
                $this->classes[$elementName]['functions'] = array_merge(
                    $this->classes[$elementName]['functions'],
                    self::CAMUNDA_EXTENSION[$elementName]['functions']
                );
            }
        }
    }

    private function getReturnType(DOMElement $element, ?string $type = null): array
    {
        $returnType = [
            'type' => $type,
            'nullable' => false,
            'list' => false,
            'simpleType' => null,
            'ref' => false,
        ];

        if (null === $type) {
            $type = $element->getAttribute('type');
            switch (true) {
                case is_array($this->isSimpleType($type)):
                    $returnType['type'] = 'string';
                    $returnType['simpleType'] = $this->isSimpleType($type);
                    break;
                case 'xsd:ID' === $type:
                case 'xsd:string' === $type:
                case 'xsd:anyURI' === $type:
                    $returnType['type'] = 'string';
                    break;
                case 'xsd:boolean' === $type:
                    $returnType['type'] = 'bool';
                    break;
                case 'xsd:integer' === $type:
                case 'xsd:int' === $type:
                    $returnType['type'] = 'int';
                    break;
                case 'xsd:IDREF' === $type:
                case 'xsd:QName' === $type:
                    $returnType['type'] = 'AbstractElement';
                    $returnType['ref'] = true;
                    break;
                case substr($type, 0, 4) !== 'xsd' && substr($type, 0, 1) === 't':
                    $returnType['type'] = substr($type, 1);
                    break;
                default:
                    throw new RuntimeException('Not handled case.');
            }
        }

        if ($element->hasAttribute('minOccurs') || $element->hasAttribute('maxOccurs')) {
            $minOccurs = $element->getAttribute('minOccurs');
            $maxOccurs = $element->getAttribute('maxOccurs');

            if (!in_array($maxOccurs, ['', '1'])) {
                $returnType['list'] = true;
            } elseif ('0' === $minOccurs && in_array($maxOccurs, ['', '1'])) {
                $returnType['nullable'] = true;
            }
        } else {
            $isId = 'xsd:ID' === $element->getAttribute('type');
            $isRequired = 'required' === $element->getAttribute('use');
            $returnType['nullable'] = !$isId && !$isRequired;
        }

        if ($element->hasAttribute('default')) {
            $returnType['default'] = $element->getAttribute('default');
            $returnType['nullable'] = false;
        }

        return $returnType;
    }

    /** @return DOMNodeList<DOMElement> */
    private function query(string $expression): DOMNodeList
    {
        /** @var DOMNodeList<DOMElement> $elements */
        $elements = (new DOMXPath($this->xsd))->query($expression);

        return $elements;
    }

    private function getXsdPath(): string
    {
        return sprintf('%s/%s', $this->getRootFolder(), self::XSD);
    }

    private function getOutputFolder(): string
    {
        return sprintf('%s/%s', $this->getRootFolder(), self::OUTPUT);
    }

    private function getRootFolder(): string
    {
        return (string) realpath(sprintf('%s/../../', dirname(__FILE__)));
    }

    private function cleanup(): void
    {
        $files = glob(sprintf('%s/*', $this->getOutputFolder()));
        assert(is_array($files));

        foreach ($files as $file) {
            if (!in_array(basename($file), ['AbstractElement.php', 'ElementList.php', 'Bpmn.php'])) {
                unlink($file);
            }
        }
    }

    /**
     * @return string[]
     */
    private function isSimpleType(string $type): ?array
    {
        $simpleType = $this->query(sprintf('/xsd:schema/xsd:simpleType[@name="%s"]', $type))->item(0);
        if (!$simpleType instanceof \DOMElement) {
            return null;
        }

        $buffer = [];
        /** @var DOMElement $element */
        foreach ($simpleType->getElementsByTagName('enumeration') as $element) {
            $buffer[] = $element->getAttribute('value');
        }

        return $buffer;
    }

    private function createBpmnClass(): void
    {
        $classSkeletonPath = sprintf('%s/src/Resources/skeleton/Bpmn.tpl.php', $this->getRootFolder());
        $classFile = sprintf('%s/Bpmn.php', $this->getOutputFolder());
        $classContent = $this->parseClassSkeleton($classSkeletonPath, [
            'namespace' => self::NAMESPACE,
            'classes' => $this->classes
        ]);
        file_put_contents($classFile, $classContent);
    }

    private function createElementClasses(): void
    {
        $classSkeletonPath = sprintf('%s/src/Resources/skeleton/Class.tpl.php', $this->getRootFolder());
        foreach ($this->classes as $config) {
            $classFile = sprintf('%s/%s.php', $this->getOutputFolder(), $config['className']);
            $config['namespace'] = self::NAMESPACE;
            $classContent = $this->parseClassSkeleton($classSkeletonPath, $config);
            file_put_contents($classFile, $classContent);
        }
    }

    public function parseClassSkeleton(string $skeletonPath, array $context): string
    {
        ob_start();
        extract($context, \EXTR_SKIP);
        include $skeletonPath;

        return (string) ob_get_clean();
    }
}
