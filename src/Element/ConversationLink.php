<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

class ConversationLink extends BaseElement
{
    public function getName(): ?string
    {
        $value = $this->getAttribute('name');

        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function hasName(): bool
    {
        return $this->hasAttribute('name');
    }

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
}
