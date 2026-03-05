<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class Association extends Artifact
{
    public function getSourceRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('sourceRef'));
    }

    public function hasSourceRef(): bool
    {
        return $this->hasAttribute('sourceRef');
    }

    public function getTargetRef(): AbstractElement
    {
        return $this->getBpmn()->getById((string) $this->getAttribute('targetRef'));
    }

    public function hasTargetRef(): bool
    {
        return $this->hasAttribute('targetRef');
    }

    public function getAssociationDirection(): string
    {
        return $this->getAttribute('associationDirection') ?? 'None';
    }

    public function hasAssociationDirection(): bool
    {
        return $this->hasAttribute('associationDirection');
    }
}
