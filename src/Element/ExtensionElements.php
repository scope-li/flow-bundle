<?php

namespace Scopeli\FlowBundle\Element;

use Scopeli\FlowBundle\ElementCamunda\Connector;
use Scopeli\FlowBundle\ElementCamunda\InputOutput;

class ExtensionElements extends AbstractElement
{
    public function getConnector() : ?Connector
    {
        $child = $this->getChild('connector');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new Connector($child, $this->getBpmn());
    }

    public function hasConnector() : bool
    {
        return $this->hasChild('connector');
    }

    public function getInputOutput() : ?InputOutput
    {
        $child = $this->getChild('inputOutput');

        if (!$child instanceof \DOMElement) {
            return null;
        }

        return new InputOutput($child, $this->getBpmn());
    }

    public function hasInputOutput() : bool
    {
        return $this->hasChild('inputOutput');
    }
}
