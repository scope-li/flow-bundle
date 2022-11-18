<?= "<?php\n" ?>

namespace <?= $namespace ?>;

<?php foreach ($useClasses as $useClass) : ?>
use <?= $useClass ?>;
<?php endforeach; ?>
<?php if ([] !== $useClasses) : ?>

<?php endif ?>
<?= $abstract ? 'abstract ' : '' ?>class <?= $className ?><?= empty($extends) ? '' : sprintf(' extends %s', $extends) ?>

{
<?php $count = 0; ?>
<?php foreach ($functions as $function) : ?>
<?php if ($function['returnType']['list']) : ?>
    /** @return ElementList<<?= $function['returnType']['type'] ?>> */
<?php endif; ?>
    public function get<?= $function['functionName'] ?>() : <?= $function['returnType']['nullable'] ? '?' : '' ?><?= $function['returnType']['list'] ? 'ElementList' : $function['returnType']['type'] ?>

    {
<?php if ($function['kind'] == 'element') : ?>
<?php if (!$function['returnType']['list']) : ?>
        $child = $this->getChild('<?= $function['name'] ?>');

<?php if ($function['returnType']['nullable']) : ?>
        if (!$child instanceof \DOMElement) {
            return null;
        }

<?php else: ?>
        assert($child instanceof \DOMElement);
<?php endif; ?>
<?php endif; ?>
<?php if ($function['returnType']['type'] == 'bool') : ?>
        return 'true' === $child->nodeValue;
<?php elseif ($function['returnType']['type'] == 'int') : ?>
        return (int) $child->nodeValue;
<?php elseif ($function['returnType']['type'] == 'string') : ?>
        return $child->nodeValue;
<?php elseif ($function['returnType']['type'] == 'AbstractElement' && $function['returnType']['list'] == false) : ?>
        return self::createElement($child, $this->getBpmn());
<?php elseif ($function['returnType']['list']) : ?>
<?php if ($function['returnType']['ref']) : ?>
        return new ElementList($this->getRefChilds('<?= $function['name'] ?>'));
<?php else: ?>
        /** @var ElementList<<?= $function['returnType']['type'] ?>> $elements */
        $elements = new ElementList($this->getChilds('<?= $function['name'] ?>'));

        return $elements;
<?php endif; ?>
<?php else: ?>
        return new <?= $function['returnType']['type'] ?>($child, $this->getBpmn());
<?php endif; ?>
<?php else: ?>
        $value = $this->getAttribute('<?= $function['name'] ?>')<?= isset($function['returnType']['default']) ? sprintf(' ?? \'%s\'', $function['returnType']['default']) : '' ?>;

<?php if ($function['returnType']['nullable']) : ?>
        if (null === $value) {
            return null;
        }

<?php endif; ?>
<?php if ($function['returnType']['type'] == 'bool') : ?>
        return 'true' === $value;
<?php elseif ($function['returnType']['type'] == 'int') : ?>
        return (int) $value;
<?php elseif ($function['returnType']['type'] == 'string') : ?>
        return (string) $value;
<?php elseif ($function['returnType']['type'] == 'simpleType') : ?>
        return new <?= $function['returnType']['type'] ?>();
<?php elseif ($function['returnType']['type'] == 'AbstractElement') : ?>
        return $this->getBpmn()->getById((string) $value);
<?php else: ?>
        return new <?= $function['returnType']['type'] ?>($value, $this->getBpmn());
<?php endif; ?>
<?php endif; ?>
    }

    public function has<?= $function['functionName'] ?>() : bool
    {
<?php if ($function['kind'] == 'element') : ?>
        return $this->hasChild('<?=  $function['name'] ?>');
<?php else: ?>
        return $this->hasAttribute('<?=  $function['name'] ?>');
<?php endif; ?>
    }
<?php $count++; ?>
<?php if ($count < count($functions)) : ?>

<?php endif ?>
<?php endforeach; ?>
}
