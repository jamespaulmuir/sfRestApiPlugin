  protected function processUpdate(sfWebRequest $request, sfForm $form)
  {
  $values = $request->getParameter($form->getName());
  $isNew = $form->isNew();
  if($isNew != true){
    <?php foreach($this->getPrimaryKeys() as $key){ ?>
        $values['<?php echo $key ?>'] = $form->getObject()-><?php echo $key ?>;
    <?php } ?>
  }

    $form->bind($values);
    if ($form->isValid())
    {        
      $this-><?php echo $this->getSingularName() ?> = $form->save();
      if($isNew){
        $response = $this->getResponse();
        $response->setStatusCode(201);
      }

      $this->setTemplate('show');
      return sfView::SUCCESS;
    }
   
  }
