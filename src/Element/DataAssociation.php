<?php

namespace Scopeli\FlowBundle\Element;

class DataAssociation extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getSourceRef() : ElementList
    {
        return new ElementList($this->getRefChilds('sourceRef'));
    }

    public function hasSourceRef() : bool
    {
        return $this->hasChild('sourceRef');
    }

    public function getTargetRef() : AbstractElement
    {
        $child = $this->getChild('targetRef');

        assert($child instanceof \DOMElement);
        return self::createElement($child, $this->getBpmn());
    }

    public function hasTargetRef() : bool
    {
        return $this->hasChild('targetRef');
    }

    public function getTransformation() : ?FormalExpression
    {
        $child = $this->getChild('transformation');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new FormalExpression($child, $this->getBpmn());
    }

    public function hasTransformation() : bool
    {
        return $this->hasChild('transformation');
    }

    /** @return ElementList<Assignment> */
    public function getAssignment() : ElementList
    {
        /** @var ElementList<Assignment> $elements */
        $elements = new ElementList($this->getChilds('assignment'));

        return $elements;
    }

    public function hasAssignment() : bool
    {
        return $this->hasChild('assignment');
    }
}
