<?php

namespace Scopeli\FlowBundle\Element;

class ResourceRole extends BaseElement
{
    public function getResourceRef() : ?AbstractElement
    {
        $child = $this->getChild('resourceRef');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return self::createElement($child, $this->getBpmn());
    }

    public function hasResourceRef() : bool
    {
        return $this->hasChild('resourceRef');
    }

    /** @return ElementList<ResourceParameterBinding> */
    public function getResourceParameterBinding() : ElementList
    {
        /** @var ElementList<ResourceParameterBinding> $elements */
        $elements = new ElementList($this->getChilds('resourceParameterBinding'));

        return $elements;
    }

    public function hasResourceParameterBinding() : bool
    {
        return $this->hasChild('resourceParameterBinding');
    }

    public function getResourceAssignmentExpression() : ?ResourceAssignmentExpression
    {
        $child = $this->getChild('resourceAssignmentExpression');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new ResourceAssignmentExpression($child, $this->getBpmn());
    }

    public function hasResourceAssignmentExpression() : bool
    {
        return $this->hasChild('resourceAssignmentExpression');
    }

    public function getName() : ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasName() : bool
    {
        return $this->hasAttribute('name');
    }
}
