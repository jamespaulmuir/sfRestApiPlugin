  public function preExecute()
  {
    $request = $this->getContext()->getRequest();
    $method = $request->getMethod();
    if($method == 'PUT' || $method == 'POST'){
        $form = new <?php echo $this->getModelClass().'Form'?>();
        $formName = $form->getName();
        $request->setParameter($formName,$request->getParameter('inputData'));
    }
  }
