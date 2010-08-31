[?php

$output = array(); 
foreach ($sf_data->getRaw('<?php echo $this->getPluralName() ?>') as $<?php echo $this->getSingularName() ?>){

    $obj =  $<?php echo $this->getSingularName() ?>->toArray();

    $output[] = $obj ;
}
   
 echo json_encode($output);
?]