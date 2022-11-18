<?php

namespace Scopeli\FlowBundle\Element;

use DOMAttr;
use DOMElement;
use DOMNamedNodeMap;
use Scopeli\FlowBundle\Exception\NotInstanceOfException;
use Scopeli\FlowBundle\Exception\RuntimeException;

class AbstractElement
{
    private DOMElement $element;

    private Bpmn $bpmn;

    public static function createElement(DOMElement $element, Bpmn $bpmn): self
    {
        $className = self::getFqnClassName($element->localName);

        if (null !== $className) {
            if (!is_a($className, AbstractElement::class, true)) {
                throw new NotInstanceOfException($className, AbstractElement::class);
            }

            /** @var AbstractElement $object */
            $object = new $className($element, $bpmn);

            return $object;
        }

        throw new RuntimeException(sprintf('No class found for "%s"', $element->localName));
    }

    public static function getFqnClassName(string $name): ?string
    {
        $fqnClassName = sprintf('Scopeli\FlowBundle\Element\%s', ucfirst($name));
        if (class_exists($fqnClassName)) {
            return $fqnClassName;
        }

        $fqnClassName = sprintf('Scopeli\FlowBundle\ElementCamunda\%s', ucfirst($name));
        if (class_exists($fqnClassName)) {
            return $fqnClassName;
        }

        return null;
    }

    public function __construct(DOMElement $element, Bpmn $bpmn)
    {
        $this->element = $element;
        $this->bpmn = $bpmn;
    }

    public function getElement(): DOMElement
    {
        return $this->element;
    }

    public function getBpmn(): Bpmn
    {
        return $this->bpmn;
    }

    public function getId(): string
    {
        return (string) $this->getAttribute('id');
    }

    public function getParent(): ?AbstractElement
    {
        if ($this->element->parentNode instanceof DOMElement) {
            return self::createElement($this->element->parentNode, $this->bpmn);
        }

        return null;
    }

    public function getAttribute(string $name): ?string
    {
        if ($this->element->attributes instanceof DOMNamedNodeMap) {
            /** @var DOMAttr $attribute */
            foreach ($this->element->attributes as $attribute) {
                if ($attribute->localName === $name) {
                    return $attribute->nodeValue;
                }
            }
        }

        return null;
    }

    public function hasAttribute(string $name): bool
    {
        return null !== $this->getAttribute($name);
    }

    public function hasChild(string $name): bool
    {
        return [] !== $this->getElementsByTagName($name);
    }

    /** @return AbstractElement[] */
    public function getChilds(string $name): array
    {
        $buffer = [];

        foreach ($this->getElementsByTagName($name) as $element) {
            $buffer[] = self::createElement($element, $this->getBpmn());
        }

        return $buffer;
    }

    public function getChild(string $name): ?DOMElement
    {
        foreach ($this->getElementsByTagName($name) as $element) {
            return $element;
        }

        return null;
    }

    /** @return AbstractElement[] */
    public function getRefChilds(string $name): array
    {
        $buffer = [];

        foreach ($this->getElementsByTagName($name) as $element) {
            $buffer[] = $this->getBpmn()->getById($element->nodeValue);
        }

        return $buffer;
    }

    /**
     * Ignore the namespace in element name (getElementsByTagNameNS needs to set one).
     * @return DOMElement[]
     */
    public function getElementsByTagName(string $name): array
    {
        $elements = [];

        /** @var DOMElement $childNode */
        foreach ($this->element->childNodes as $childNode) {
            if ($name === $childNode->localName) {
                $elements[] = $childNode;
            }
        }

        return $elements;
    }
}
