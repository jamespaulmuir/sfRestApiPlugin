  public function execute<?php echo $relationAlias;?>(sfWebRequest $request)
  {
    $this-><?php echo $relationAlias;?> = $this->getRoute()->getObject()->get<?php echo $relationAlias;?>();
    return $this->renderPartial('<?php echo $this->getModuleName()?>/relation', array('alias'=>'<?php echo $relationAlias;?>','object' => $this-><?php echo $relationAlias;?>));
  }
