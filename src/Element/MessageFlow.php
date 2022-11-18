<?php

namespace Scopeli\FlowBundle\Element;

class MessageFlow extends BaseElement
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

    public function getMessageRef() : ?AbstractElement
    {
        $value = $this->getAttribute('messageRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasMessageRef() : bool
    {
        return $this->hasAttribute('messageRef');
    }
}
