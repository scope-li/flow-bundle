<?php

namespace Scopeli\FlowBundle\Element;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Scopeli\FlowBundle\Exception\WrongTypeException;

/**
 * @template TClass of \Scopeli\FlowBundle\Element\AbstractElement
 * @implements IteratorAggregate<int, TClass>
 */
class ElementList implements IteratorAggregate, Countable
{
    /** @var TClass[] */
    private array $elements = [];

    /**
     * @param TClass[]|array<TClass> $elements
     */
    public function __construct($elements)
    {
        foreach ($elements as $element) {
            if (!$element instanceof AbstractElement) {
                throw new WrongTypeException(AbstractElement::class);
            }

            $this->elements[] = $element;
        }
    }

    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * @return ArrayIterator<int, TClass>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @return TClass
     */
    public function get(int $key): AbstractElement
    {
        return $this->elements[$key];
    }

    public function hasElements(): bool
    {
        return $this->count() > 0;
    }

    /**
     * @return TClass|null
     */
    public function find(string $id): ?AbstractElement
    {
        foreach ($this->elements as $element) {
            if ($id === $element->getId()) {
                return $element;
            }
        }

        return null;
    }
}
