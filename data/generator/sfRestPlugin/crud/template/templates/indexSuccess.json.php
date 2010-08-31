[?php

$output = array(); 
foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>){
<?php foreach ($this->getColumns() as $column): ?>
    $obj['<?php echo $column->getPhpName() ?>'] =  $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();
<?php endforeach; ?>
    $obj['href'] = url_for('@<?php echo $this->getUrlForAction('show') ?>?sf_format=json&<?php echo $this->getPrimaryKeyUrlParams() ?>, true);
    $output[] = $obj ;
}
   
 echo json_encode($output);
?]