<?php

class sfRestRelationRouteCollection extends sfRestRouteCollection
{
  protected
    $routeClass = 'sfRestRoute';

  /**
   * Constructor.
   *
   * @param array $options An array of options
   */
  public function __construct(array $options)
  {
    parent::__construct($options);

    if (!isset($this->options['model']))
    {
      throw new InvalidArgumentException(sprintf('You must pass a "model" option to %s ("%s" route)', get_class($this), $this->options['name']));
    }

    $this->options = array_merge(array(
      'actions'             => false,
      'module'              => $this->options['name'],
      'prefix_path'         => '/'.$this->options['name'],
      'column'              => isset($this->options['column']) ? $this->options['column'] : 'id',
      'model_methods'       => array(),
      'with_wildcard_routes' => false,
    ), $this->options);

    $this->options['requirements'] = array_merge(array($this->options['column'] => '\d+'), $this->options['requirements']);
    $this->options['model_methods'] = array_merge(array('list' => null, 'object' => null), $this->options['model_methods']);

    if (isset($this->options['route_class']))
    {
      $this->routeClass = $this->options['route_class'];
    }

    $this->generateRoutes();
  }

  protected function generateRoutes()
  {
    // collection actions
    if (isset($this->options['collection_actions']))
    {
      foreach ($this->options['collection_actions'] as $action => $methods)
      {
        $this->routes[$this->getRoute($action)] = $this->getRouteForCollection($action, $methods);
      }
    }

    // "standard" actions
    $actions = false === $this->options['actions'] ? $this->getDefaultActions() : $this->options['actions'];
    foreach ($actions as $action)
    {
      $method = 'getRouteFor'.ucfirst($action);
      if (!method_exists($this, $method))
      {
        throw new InvalidArgumentException(sprintf('Unable to generate a route for the "%s" action.', $action));
      }

      $this->routes[$this->getRoute($action)] = $this->$method();
    }

    // object actions
    if (isset($this->options['object_actions']))
    {
      foreach ($this->options['object_actions'] as $action => $methods)
      {
        $this->routes[$this->getRoute($action)] = $this->getRouteForObject($action, $methods);
      }
    }

    if ($this->options['with_wildcard_routes'])
    {
    
    }
  }

  protected function getRouteForCollection($action, $methods)
  {
    return new $this->routeClass(
      sprintf('%s/:%s/%s.:sf_format', $this->options['local'], $this->options['local_key'], $this->options['relation_alias'])
      ,
      array('module' => $this->options['module'], 'action' => $action, 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => $methods)),
      array('model' => $this->options['model'], 'type' => 'list', 'method' => $this->options['model_methods']['list'])
    );
  }

  protected function getRouteForObject($action, $methods)
  {
    return new $this->routeClass(
      sprintf('%s/:%s/%s.:sf_format', $this->options['prefix_path'], $this->options['column'], $action),
      array('module' => $this->options['module'], 'action' => $action, 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => $methods)),
      array('model' => $this->options['model'], 'type' => 'object', 'method' => $this->options['model_methods']['object'])
    );
  }

  protected function getRouteForList()
  {
    return new $this->routeClass(
      sprintf('%s/:%s/%s.:sf_format', $this->options['local'], $this->options['local_key'], $this->options['relation_alias']),
      array('module' => $this->options['module'], 'action' => $this->getActionMethod('list'), 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => 'get')),
      array('model' => $this->options['model'], 'type' => 'list', 'method' => $this->options['model_methods']['list'])
    );
  }

  protected function getRouteForCreate()
  {
    return new $this->routeClass(
      $this->getPattern(),
      array('module' => $this->options['module'], 'action' => $this->getActionMethod('create'), 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => 'post')),
      array('model' => $this->options['model'], 'type' => 'object')
    );
  }

  protected function getRouteForShow()
  {
    return new $this->routeClass(
      $this->getPattern(),
      array('module' => $this->options['module'], 'action' => $this->getActionMethod('show'), 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => 'get')),
      array('model' => $this->options['model'], 'type' => 'object', 'method' => $this->options['model_methods']['object'])
    );
  }

    protected function getRouteForUpdate()
  {
    return new $this->routeClass(
      $this->getPattern(),
      array('module' => $this->options['module'], 'action' => $this->getActionMethod('update'), 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => 'put')),
      array('model' => $this->options['model'], 'type' => 'object', 'method' => $this->options['model_methods']['object'])
    );
  }

  protected function getRouteForDelete()
  {
    return new $this->routeClass(
      $this->getPattern(),
      array('module' => $this->options['module'], 'action' => $this->getActionMethod('delete'), 'sf_format' => 'json'),
      array_merge($this->options['requirements'], array('sf_method' => 'delete')),
      array('model' => $this->options['model'], 'type' => 'object', 'method' => $this->options['model_methods']['object'])
    );
  }

  protected function getDefaultActions()
  {
    $actions = array('list','show', 'create', 'update', 'delete');

    return $actions;
  }

  protected function getRoute($action)
  {
    return 'list' == $action ? $this->options['name'] : $this->options['name'].'_'.$action;
  }

  protected function getActionMethod($action)
  {
    return 'list' == $action ? 'index' : $action;
  }

  protected function getPattern()
  {
      return sprintf('%s/:%s/%s/:%s.:sf_format', $this->options['local'], $this->options['local_key'], $this->options['relation_alias'], $this->options['foreign_key']);
  }
}
