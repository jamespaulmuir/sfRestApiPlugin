<<?php echo $this->getModelClass() ?>Set>
[?php foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): ?]
<<?php echo $this->getModelClass() ;?>>
<href>[?php echo url_for('<?php echo $this->getUrlForAction('show') ?>?sf_format=xml&<?php echo $this->getPrimaryKeyUrlParams() ?>, true);?]</href>
<?php foreach ($this->getColumns() as $column): ?>
<<?php echo $column->getPhpName() ?>>[?php echo htmlentities($<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>());?]</<?php echo $column->getPhpName() ?>>
<?php endforeach; ?>
</<?php echo $this->getModelClass() ?>>
[?php endforeach; ?]
</<?php echo $this->getModelClass() ?>Set>
