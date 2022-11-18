<?php

namespace Scopeli\FlowBundle\Element;

class BoundaryEvent extends CatchEvent
{
    public function getCancelActivity() : bool
    {
        $value = $this->getAttribute('cancelActivity') ?? 'true';

        return 'true' === $value;
    }

    public function hasCancelActivity() : bool
    {
        return $this->hasAttribute('cancelActivity');
    }

    public function getAttachedToRef() : AbstractElement
    {
        $value = $this->getAttribute('attachedToRef');

        return $this->getBpmn()->getById((string) $value);
    }

    public function hasAttachedToRef() : bool
    {
        return $this->hasAttribute('attachedToRef');
    }
}
