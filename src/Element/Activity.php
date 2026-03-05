<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Element;

use DOMElement;

abstract class Activity extends FlowNode
{
    public function getIoSpecification(): ?IoSpecification
    {
        $child = $this->getChild('ioSpecification');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new IoSpecification($child, $this->getBpmn());
    }

    public function hasIoSpecification(): bool
    {
        return $this->hasChild('ioSpecification');
    }

    /** @return ElementList<Property> */
    public function getProperty(): ElementList
    {
        /** @var ElementList<Property> $elements */
        $elements = new ElementList($this->getChilds('property'));

        return $elements;
    }

    public function hasProperty(): bool
    {
        return $this->hasChild('property');
    }

    /** @return ElementList<DataInputAssociation> */
    public function getDataInputAssociation(): ElementList
    {
        /** @var ElementList<DataInputAssociation> $elements */
        $elements = new ElementList($this->getChilds('dataInputAssociation'));

        return $elements;
    }

    public function hasDataInputAssociation(): bool
    {
        return $this->hasChild('dataInputAssociation');
    }

    /** @return ElementList<DataOutputAssociation> */
    public function getDataOutputAssociation(): ElementList
    {
        /** @var ElementList<DataOutputAssociation> $elements */
        $elements = new ElementList($this->getChilds('dataOutputAssociation'));

        return $elements;
    }

    public function hasDataOutputAssociation(): bool
    {
        return $this->hasChild('dataOutputAssociation');
    }

    /** @return ElementList<Performer> */
    public function getPerformer(): ElementList
    {
        /** @var ElementList<Performer> $elements */
        $elements = new ElementList($this->getChilds('performer'));

        return $elements;
    }

    public function hasPerformer(): bool
    {
        return $this->hasChild('performer');
    }

    public function getMultiInstanceLoopCharacteristics(): ?MultiInstanceLoopCharacteristics
    {
        $child = $this->getChild('multiInstanceLoopCharacteristics');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new MultiInstanceLoopCharacteristics($child, $this->getBpmn());
    }

    public function hasMultiInstanceLoopCharacteristics(): bool
    {
        return $this->hasChild('multiInstanceLoopCharacteristics');
    }

    public function getStandardLoopCharacteristics(): ?StandardLoopCharacteristics
    {
        $child = $this->getChild('standardLoopCharacteristics');

        if (!$child instanceof DOMElement) {
            return null;
        }

        return new StandardLoopCharacteristics($child, $this->getBpmn());
    }

    public function hasStandardLoopCharacteristics(): bool
    {
        return $this->hasChild('standardLoopCharacteristics');
    }

    public function getIsForCompensation(): bool
    {
        return 'true' === ($this->getAttribute('isForCompensation') ?? 'false');
    }

    public function hasIsForCompensation(): bool
    {
        return $this->hasAttribute('isForCompensation');
    }

    public function getStartQuantity(): int
    {
        return (int) ($this->getAttribute('startQuantity') ?? '1');
    }

    public function hasStartQuantity(): bool
    {
        return $this->hasAttribute('startQuantity');
    }

    public function getCompletionQuantity(): int
    {
        return (int) ($this->getAttribute('completionQuantity') ?? '1');
    }

    public function hasCompletionQuantity(): bool
    {
        return $this->hasAttribute('completionQuantity');
    }

    public function getDefault(): ?AbstractElement
    {
        $value = $this->getAttribute('default');

        if (null === $value) {
            return null;
        }

        return $this->getBpmn()->getById($value);
    }

    public function hasDefault(): bool
    {
        return $this->hasAttribute('default');
    }
}
