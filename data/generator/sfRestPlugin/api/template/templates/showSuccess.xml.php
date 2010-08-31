<<?php echo $this->getModelClass() ?>>
<href>[?php echo url_for('<?php echo $this->getUrlForAction('show') ?>?sf_format=xml&<?php echo $this->getPrimaryKeyUrlParams() ?>, true);?]</href>
<?php foreach ($this->getColumns() as $column): ?>
<<?php echo $column->getPhpName() ?>>[?= $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();?]</<?php echo $column->getPhpName() ?>>
<?php endforeach; ?>
</<?php echo $this->getModelClass() ?>>