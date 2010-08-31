  public function executeCreate(sfWebRequest $request)
  {
<?php if (isset($this->params['with_doctrine_route']) && $this->params['with_doctrine_route']): ?>
<?php else: ?>
    $this->forward404Unless($request->isMethod('post'));

<?php endif; ?>
    $this->form = new <?php echo $this->getModelClass().'Form' ?>();

    $result = $this->processUpdate($request, $this->form);
    if($result === sfView::SUCCESS){
        return $result;
    }

    $response = $this->getResponse();
    $response->setStatusCode(500);
    $this->setTemplate('edit');
    return sfView::ERROR;
  }
