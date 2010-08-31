[?php
<?php foreach ($this->getColumns() as $column): ?>
$output['<?php echo $column->getPhpName() ?>'] =  $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();
<?php endforeach; ?>
$output['href'] = url_for('@<?php echo $this->getUrlForAction('show') ?>?sf_format=json&<?php echo $this->getPrimaryKeyUrlParams() ?>, true);

echo json_encode($output); ?]