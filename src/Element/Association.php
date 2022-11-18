<?php

namespace Scopeli\FlowBundle\Element;

class Association extends Artifact
{
    public function getSourceRef() : AbstractElement
    {
        $value = $this->getAttribute('sourceRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasSourceRef() : bool
    {
        return $this->hasAttribute('sourceRef');
    }

    public function getTargetRef() : AbstractElement
    {
        $value = $this->getAttribute('targetRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasTargetRef() : bool
    {
        return $this->hasAttribute('targetRef');
    }

    public function getAssociationDirection() : string
    {
        $value = $this->getAttribute('associationDirection') ?? 'None';

        return (string) $value;
    }

    public function hasAssociationDirection() : bool
    {
        return $this->hasAttribute('associationDirection');
    }
}
