<?php

namespace Scopeli\FlowBundle\Element;

class Participant extends BaseElement
{
    /** @return ElementList<AbstractElement> */
    public function getInterfaceRef() : ElementList
    {
        return new ElementList($this->getRefChilds('interfaceRef'));
    }

    public function hasInterfaceRef() : bool
    {
        return $this->hasChild('interfaceRef');
    }

    /** @return ElementList<AbstractElement> */
    public function getEndPointRef() : ElementList
    {
        return new ElementList($this->getRefChilds('endPointRef'));
    }

    public function hasEndPointRef() : bool
    {
        return $this->hasChild('endPointRef');
    }

    public function getParticipantMultiplicity() : ?ParticipantMultiplicity
    {
        $child = $this->getChild('participantMultiplicity');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new ParticipantMultiplicity($child, $this->getBpmn());
    }

    public function hasParticipantMultiplicity() : bool
    {
        return $this->hasChild('participantMultiplicity');
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

    public function getProcessRef() : ?AbstractElement
    {
        $value = $this->getAttribute('processRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasProcessRef() : bool
    {
        return $this->hasAttribute('processRef');
    }
}
