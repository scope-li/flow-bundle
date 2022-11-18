<?php

namespace Scopeli\FlowBundle\Element;

class IoSpecification extends BaseElement
{
    /** @return ElementList<DataInput> */
    public function getDataInput() : ElementList
    {
        /** @var ElementList<DataInput> $elements */
        $elements = new ElementList($this->getChilds('dataInput'));

        return $elements;
    }

    public function hasDataInput() : bool
    {
        return $this->hasChild('dataInput');
    }

    /** @return ElementList<DataOutput> */
    public function getDataOutput() : ElementList
    {
        /** @var ElementList<DataOutput> $elements */
        $elements = new ElementList($this->getChilds('dataOutput'));

        return $elements;
    }

    public function hasDataOutput() : bool
    {
        return $this->hasChild('dataOutput');
    }

    /** @return ElementList<InputSet> */
    public function getInputSet() : ElementList
    {
        /** @var ElementList<InputSet> $elements */
        $elements = new ElementList($this->getChilds('inputSet'));

        return $elements;
    }

    public function hasInputSet() : bool
    {
        return $this->hasChild('inputSet');
    }

    /** @return ElementList<OutputSet> */
    public function getOutputSet() : ElementList
    {
        /** @var ElementList<OutputSet> $elements */
        $elements = new ElementList($this->getChilds('outputSet'));

        return $elements;
    }

    public function hasOutputSet() : bool
    {
        return $this->hasChild('outputSet');
    }
}
