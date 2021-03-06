  public function executeDelete(sfWebRequest $request)
  {
    
<?php if (isset($this->params['with_doctrine_route']) && $this->params['with_doctrine_route']): ?>
    $this->getRoute()->getObject()->delete();
<?php else: ?>
    $this->forward404Unless($<?php echo $this->getSingularName() ?> = Doctrine::getTable('<?php echo $this->getModelClass() ?>')->find(<?php echo $this->getRetrieveByPkParamsForAction(43) ?>), sprintf('Object <?php echo $this->getSingularName() ?> does not exist (%s).', <?php echo $this->getRetrieveByPkParamsForAction(43) ?>));
    $<?php echo $this->getSingularName() ?>->delete();
<?php endif; ?>
    return sfView::NONE;
  }
