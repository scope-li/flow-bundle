<?php

namespace Scopeli\FlowBundle\Element;

class UserTask extends Task
{
    /** @return ElementList<Rendering> */
    public function getRendering() : ElementList
    {
        /** @var ElementList<Rendering> $elements */
        $elements = new ElementList($this->getChilds('rendering'));

        return $elements;
    }

    public function hasRendering() : bool
    {
        return $this->hasChild('rendering');
    }

    public function getImplementation() : string
    {
        $value = $this->getAttribute('implementation') ?? '##unspecified';

        return (string) $value;
    }

    public function hasImplementation() : bool
    {
        return $this->hasAttribute('implementation');
    }

    public function getFormKey() : ?string
    {
        $value = $this->getAttribute('formKey');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasFormKey() : bool
    {
        return $this->hasAttribute('formKey');
    }

    public function getAssignee() : ?string
    {
        $value = $this->getAttribute('assignee');

        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    public function hasAssignee() : bool
    {
        return $this->hasAttribute('assignee');
    }
}
