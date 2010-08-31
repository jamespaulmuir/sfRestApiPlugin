    public function execute<?php echo $relationAlias;?>($request)
    {
        $this-><?php echo $relationAlias;?> = $this->getRoute()->getObject()->get<?php echo $relationAlias;?>();
        return $this->renderPartial('<?php echo $this->getModuleName()?>/relation', array('object' => $this-><?php echo $relationAlias;?>));
    }
