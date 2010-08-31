<[?php echo get_class($object); ?]>
<href></href>
<?php foreach ($this->getColumns() as $column): ?>
<<?php echo $column->getPhpName() ?>>[?php echo $object->identifier() ?]</<?php echo $column->getPhpName() ?>>
<?php endforeach; ?>
</[?php echo get_class($object); ?]>
<[?php echo get_class($object); ?]>[?php echo $object->identifier();?]</[?php echo get_class($object); ?]>