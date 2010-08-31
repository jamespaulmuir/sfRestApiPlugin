[?php
$output =  $sf_data->getRaw('<?php echo $this->getSingularName() ?>')->toArray();

echo json_encode($output); ?]