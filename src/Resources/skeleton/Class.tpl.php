<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

<?php
$needsDomElement = false;
foreach ($functions as $function) {
    if ($function['kind'] == 'element' && !$function['returnType']['list'] && $function['returnType']['nullable']) {
        $needsDomElement = true;
        break;
    }
    if ($function['kind'] == 'element' && !$function['returnType']['list'] && !$function['returnType']['nullable']) {
        $needsDomElement = true;
        break;
    }
}
$allUseClasses = $useClasses;
if ($needsDomElement) {
    array_unshift($allUseClasses, 'DOMElement');
}
sort($allUseClasses);
$allUseClasses = array_unique($allUseClasses);
?>
<?php foreach ($allUseClasses as $useClass) : ?>
use <?= $useClass ?>;
<?php endforeach; ?>
<?php if ([] !== $allUseClasses) : ?>

<?php endif ?>
<?php if ([] === $functions) : ?>
<?= $abstract ? 'abstract ' : '' ?>class <?= $className ?><?= empty($extends) ? '' : sprintf(' extends %s', $extends) ?> {}
<?php else: ?>
<?= $abstract ? 'abstract ' : '' ?>class <?= $className ?><?= empty($extends) ? '' : sprintf(' extends %s', $extends) ?>

{
<?php $count = 0; ?>
<?php foreach ($functions as $function) : ?>
<?php if ($function['returnType']['list']) : ?>
    /** @return ElementList<<?= $function['returnType']['type'] ?>> */
<?php endif; ?>
    public function get<?= $function['functionName'] ?>(): <?= $function['returnType']['nullable'] ? '?' : '' ?><?= $function['returnType']['list'] ? 'ElementList' : $function['returnType']['type'] ?>

    {
<?php if ($function['kind'] == 'element') : ?>
<?php if (!$function['returnType']['list']) : ?>
        $child = $this->getChild('<?= $function['name'] ?>');

<?php if ($function['returnType']['nullable']) : ?>
        if (!$child instanceof DOMElement) {
            return null;
        }

<?php else: ?>
        assert($child instanceof DOMElement);
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
<?php if (isset($function['returnType']['default'])) : ?>
<?php if ($function['returnType']['type'] == 'bool') : ?>
        return 'true' === ($this->getAttribute('<?= $function['name'] ?>') ?? '<?= $function['returnType']['default'] ?>');
<?php elseif ($function['returnType']['type'] == 'int') : ?>
        return (int) ($this->getAttribute('<?= $function['name'] ?>') ?? '<?= $function['returnType']['default'] ?>');
<?php else: ?>
        return $this->getAttribute('<?= $function['name'] ?>') ?? '<?= $function['returnType']['default'] ?>';
<?php endif; ?>
<?php else: ?>
<?php if ($function['returnType']['nullable']) : ?>
        $value = $this->getAttribute('<?= $function['name'] ?>');

        if (null === $value) {
            return null;
        }

<?php if ($function['returnType']['type'] == 'bool') : ?>
        return 'true' === $value;
<?php elseif ($function['returnType']['type'] == 'int') : ?>
        return (int) $value;
<?php elseif ($function['returnType']['type'] == 'string') : ?>
        return $value;
<?php elseif ($function['returnType']['type'] == 'AbstractElement') : ?>
        return $this->getBpmn()->getById($value);
<?php else: ?>
        return new <?= $function['returnType']['type'] ?>($value, $this->getBpmn());
<?php endif; ?>
<?php else: ?>
<?php if ($function['returnType']['type'] == 'bool') : ?>
        return 'true' === $this->getAttribute('<?= $function['name'] ?>');
<?php elseif ($function['returnType']['type'] == 'int') : ?>
        return (int) $this->getAttribute('<?= $function['name'] ?>');
<?php elseif ($function['returnType']['type'] == 'string') : ?>
        return (string) $this->getAttribute('<?= $function['name'] ?>');
<?php elseif ($function['returnType']['type'] == 'simpleType') : ?>
        return new <?= $function['returnType']['type'] ?>();
<?php elseif ($function['returnType']['type'] == 'AbstractElement') : ?>
        return $this->getBpmn()->getById((string) $this->getAttribute('<?= $function['name'] ?>'));
<?php else: ?>
        return new <?= $function['returnType']['type'] ?>((string) $this->getAttribute('<?= $function['name'] ?>'), $this->getBpmn());
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
    }

    public function has<?= $function['functionName'] ?>(): bool
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
<?php endif; ?>
