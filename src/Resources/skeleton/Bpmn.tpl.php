<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use DOMElement;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Scopeli\FlowBundle\Exception\BpmnElementNotFoundByIdException;
use Scopeli\FlowBundle\Exception\LogicException;
use Scopeli\FlowBundle\Exception\RuntimeException;

class Bpmn extends DOMDocument
{
    /**
     * @return ElementList<AbstractElement>
     */
    public function query(string $expression): ElementList
    {
        $elements = (new DOMXPath($this))->query($expression);

        $buffer = [];
        if ($elements instanceof DOMNodeList) {
            /** @var DOMElement $element */
            foreach ($elements as $element) {
                $buffer[] = $this->createAbstractElement($element, $this);
            }
        }

        return new ElementList($buffer);
    }

    public function findById(string $id): ?AbstractElement
    {
        $elements = $this->query(sprintf('//*[@id="%s"]', $id));

        return $elements->find($id);
    }

    /**
     * @return ElementList<AbstractElement>
     */
    public function findByMessageRef(string $id): ElementList
    {
        return $this->query(sprintf('//*[@messageRef="%s"]', $id));
    }

    public function getById(string $id): AbstractElement
    {
        $element = $this->findById($id);

        if ($element instanceof AbstractElement) {
            return $element;
        }

        throw new BpmnElementNotFoundByIdException($id);
    }

    public function getFlowNodeById(string $id): FlowNode
    {
        $element = $this->findById($id);

        if ($element instanceof FlowNode) {
            return $element;
        }

        throw new LogicException(sprintf('Element with id "%s" is no flowNode.', $id));
    }

    public function getFlowElementById(string $id): FlowElement
    {
        $element = $this->findById($id);

        if ($element instanceof FlowElement) {
            return $element;
        }

        throw new LogicException(sprintf('Element with id "%s" is no flowNode.', $id));
    }

    public function getMessageByName(string $name): Message
    {
        /** @var Message $message */
        foreach ($this->findAllMessage() as $message) {
            if ($name === $message->getName()) {
                return $message;
            }
        }

        throw new RuntimeException(sprintf('No message with name "%s" found.', $name));
    }

    /**
     * @param string[] $cache
     */
    public function isLeadsTo(FlowNode $source, FlowNode $target, array $cache = []): bool
    {
        if ($source->getId() === $target->getId()) {
            return true;
        }

        $found = false;

        $cache[] = $source->getId();
        /** @var SequenceFlow $outgoing */
        foreach ($source->getOutgoing() as $outgoing) {
            $target = $outgoing->getTargetRef();
            assert($target instanceof FlowNode);

            if (!in_array($target->getId(), $cache)) {
                $found = $target->getId() === $target->getId() || $this->isLeadsTo($target, $target, $cache);

                if ($found) {
                    break;
                }
            }
        }

        return $found;
    }

<?php foreach ($classes as $class) : ?>
    /** @return ElementList<<?= $class['className'] ?>> */
    public function findAll<?= $class['className'] ?>(): ElementList
    {
        /** @var ElementList<<?= $class['className'] ?>> $buffer */
        $buffer = $this->findAll(lcfirst('<?= $class['className'] ?>'));

        return $buffer;
    }

    public function find<?= $class['className'] ?>(string $id): ?<?= $class['className'] ?>

    {
        /** @var <?= $class['className'] ?>|null $buffer */
        $buffer = $this->find('<?= $class['className'] ?>', $id);

        return $buffer;
    }

    public function get<?= $class['className'] ?>(string $id): <?= $class['className'] ?>

    {
        /** @var <?= $class['className'] ?> $buffer */
        $buffer = $this->get('<?= $class['className'] ?>', $id);

        return $buffer;
    }

<?php endforeach; ?>
    protected function createAbstractElement(DOMElement $element, Bpmn $bpmn): AbstractElement
    {
        return AbstractElement::createElement($element, $bpmn);
    }

    /**
     * @return ElementList<AbstractElement>
     */
    private function findAll(string $name): ElementList
    {
        /** @var ElementList<AbstractElement> $elements */
        $elements = $this->getElementListByTagName($name);

        return $elements;
    }

    private function find(string $elementName, string $elementId): ?AbstractElement
    {
        return $this->findAll(lcfirst($elementName))->find($elementId);
    }

    private function get(string $elementName, string $elementId): AbstractElement
    {
        $element = $this->findAll(lcfirst($elementName))->find($elementId);

        if ($element instanceof AbstractElement) {
            return $element;
        }

        throw new LogicException(sprintf('No "%s" element with id "%s" found.', $elementName, $elementId));
    }

    /**
     * @return ElementList<AbstractElement>
     */
    private function getElementListByTagName(string $name): ElementList
    {
        $nodes = $this->getElementsByTagName($name);

        $buffer = [];
        /** @var DOMElement $element */
        foreach ($nodes as $element) {
            $buffer[] = $this->createAbstractElement($element, $this);
        }

        return new ElementList($buffer);
    }
}
