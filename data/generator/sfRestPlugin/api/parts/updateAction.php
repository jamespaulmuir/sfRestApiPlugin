  public function executeUpdate(sfWebRequest $request)
  {
<?php if (isset($this->params['with_doctrine_route']) && $this->params['with_doctrine_route']): ?>
    $this->form = new <?php echo $this->getModelClass().'Form' ?>($this->getRoute()->getObject());
<?php else: ?>
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $<?php echo $this->getSingularName() ?> = Doctrine::getTable('<?php echo $this->getModelClass() ?>')->find(<?php echo $this->getRetrieveByPkParamsForAction(43) ?>);
    if($<?php echo $this->getSingularName() ?> != null){
        $this->form = new <?php echo $this->getModelClass().'Form' ?>($<?php echo $this->getSingularName() ?>);
    }
    else {
        $this->form = new <?php echo $this->getModelClass().'Form' ?>();
    }
    
<?php endif; ?>
    
    $result = $this->processUpdate($request, $this->form);

    if($result === sfView::SUCCESS){
        return $result;
    }
    $this-><?php echo $this->getSingularName() ?> = $<?php echo $this->getSingularName() ?>;

    $response = $this->getResponse();
    $response->setStatusCode(500);
    $this->setTemplate('edit');
    return sfView::ERROR;
  }
