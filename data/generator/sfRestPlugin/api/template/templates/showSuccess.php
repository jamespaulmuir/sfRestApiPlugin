<table>
  <tbody>
<?php foreach ($this->getColumns() as $column): ?>
    <tr>
      <th><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?>:</th>
      <td>[?= $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

<hr />

<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
<a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]">List</a>
<?php else: ?>
<a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index') ?]">List</a>
<?php endif; ?>