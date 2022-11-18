<?php

namespace Scopeli\FlowBundle\Element;

class ConversationLink extends BaseElement
{
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
}
