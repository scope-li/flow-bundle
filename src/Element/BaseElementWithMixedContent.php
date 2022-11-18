<?php

namespace Scopeli\FlowBundle\Element;

abstract class BaseElementWithMixedContent extends AbstractElement
{
    /** @return ElementList<Documentation> */
    public function getDocumentation() : ElementList
    {
        /** @var ElementList<Documentation> $elements */
        $elements = new ElementList($this->getChilds('documentation'));

        return $elements;
    }

    public function hasDocumentation() : bool
    {
        return $this->hasChild('documentation');
    }

    public function getExtensionElements() : ?ExtensionElements
    {
        $child = $this->getChild('extensionElements');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new ExtensionElements($child, $this->getBpmn());
    }

    public function hasExtensionElements() : bool
    {
        return $this->hasChild('extensionElements');
    }
}
