<?php

namespace Scopeli\FlowBundle\ElementCamunda;

use DOMElement;
use Scopeli\FlowBundle\Element\Bpmn;
use Scopeli\FlowBundle\Element\AbstractElement;

class Connector extends AbstractElement
{
    protected string $connectorId;

    protected ?InputOutput $inputOutput = null;

    public function __construct(DOMElement $element, Bpmn $bpmn)
    {
        parent::__construct($element, $bpmn);

        /** @var DOMElement $childNode */
        foreach ($element->childNodes as $childNode) {
            if ('connectorId' === $childNode->localName) {
                $this->connectorId = $childNode->nodeValue;
            }
        }

        if ($this->hasInputOutput()) {
            /** @var DOMElement $childNode */
            foreach ($element->childNodes as $childNode) {
                if ('inputOutput' === $childNode->localName) {
                    $this->inputOutput = new InputOutput($childNode, $bpmn);
                }
            }
        }
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }

    public function getInputOutput(): ?InputOutput
    {
        return $this->inputOutput;
    }

    public function hasInputOutput(): bool
    {
        return $this->hasChild('inputOutput');
    }
}
