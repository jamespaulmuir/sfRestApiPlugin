public function preExecute()
{
    $request = $this->getContext()->getRequest();
    $method = $request->getMethod();
    if($method == 'PUT' || $method == 'POST'){
        $form = new GroupForm($this->getRoute()->getObject());
        $formName = $form->getName();
        $request->setParameter($formName, $request->getParameter('inputData'));
    }
}