<?php

namespace Scopeli\FlowBundle\Element;

class Message extends RootElement
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

    public function getItemRef() : ?AbstractElement
    {
        $value = $this->getAttribute('itemRef');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasItemRef() : bool
    {
        return $this->hasAttribute('itemRef');
    }
}
