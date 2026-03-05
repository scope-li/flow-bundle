<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class BoundaryEvent extends CatchEvent
{
    public function getCancelActivity(): bool
    {
        return 'true' === ($this->getAttribute('cancelActivity') ?? 'true');
    }

    public function hasCancelActivity(): bool
    {
        return $this->hasAttribute('cancelActivity');
    }

    public function getAttachedToRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('attachedToRef'));
    }

    public function hasAttachedToRef(): bool
    {
        return $this->hasAttribute('attachedToRef');
    }
}
