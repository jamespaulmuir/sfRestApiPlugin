<?php $form = $this->getFormObject() ?>
<h1><?php echo sfInflector::humanize($this->getModuleName()) ?> List</h1>

<table>
  <thead>
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
      <th><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?></th>
<?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    [?php foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): ?]
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
<?php if ($column->isPrimaryKey()): ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
      <td><a href="[?php echo url_for('<?php echo $this->getUrlForAction('show') ?>', $<?php echo $this->getSingularName() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</a></td>
<?php else: ?>
      <td><a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/<?php echo 'show' ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</a></td>
<?php endif; ?>
<?php else: ?>
      <td>[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</td>
<?php endif; ?>
<?php endforeach; ?>
    </tr>
    [?php endforeach; ?]
  </tbody>
</table>

