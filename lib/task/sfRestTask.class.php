<?php

class sfRestInitAdminTask extends sfBaseTask
{

    protected function configure()
    {
        $this->namespace = 'rest';
        $this->name = 'init-module';
        $this->briefDescription = 'Initializes a REST module based on a Doctrine Model';
        $this->addArguments(array(
                new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
                new sfCommandArgument('module', sfCommandArgument::REQUIRED, 'The module name'),
                new sfCommandArgument('model', sfCommandArgument::REQUIRED, 'The model class name'),
            ));
        $this->detailedDescription = <<<EOF
Generate a sfRest Module.

The [rest:init-module|INFO] task generates a REST module:

  [./symfony rest:init-module api user User|INFO[

The task creates a [%module%|COMMENT] module in the [%application|COMMENT] application
for the model class [%model%|COMMENT].

The created module is an empty one that inherits its actions and templates from
a runtime generated module in [%sf_app_cache_dir%/modules/auto%module|COMMENT].

EOF;
    }


    protected function execute($arguments = array(), $options = array())
    {
        $properties = parse_ini_file(sfConfig::get('sf_config_dir').'/properties.ini', true);

        $constants = array(
          'PROJECT_NAME'   => isset($properties['symfony']['name']) ? $properties['symfony']['name'] : 'symfony',
          'APP_NAME'       => $arguments['application'],
          'MODULE_NAME'    => $arguments['module'],
          'UC_MODULE_NAME' => ucfirst($arguments['module']),
          'MODEL_CLASS'    => $arguments['model'],
          'AUTHOR_NAME'    => isset($properties['symfony']['author']) ? $properties['symfony']['author'] : 'Your name here',
        );

        $moduleDir = sfConfig::get('sf_app_module_dir').'/'.$arguments['module'];

        $finder = sfFinder::type('any')->discard('.sf');
        $dirs = $this->configuration->getGeneratorSkeletonDirs('sfRestPlugin', 'api');
        
        foreach($dirs as $dir){
            if(is_dir($dir)){
                $this->getFilesystem()->mirror($dir, $moduleDir, $finder);
                break;
            }
        }


  // create a route
    $model = $arguments['model'];
    $name = strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), '\\1_\\2', $model));

    $routing = sfConfig::get('sf_app_config_dir').'/routing.yml';
    $content = file_get_contents($routing);
    $routesArray = sfYaml::load($content);

    if (!isset($routesArray[$name]))
    {

        $databaseManager = new sfDatabaseManager($this->configuration);

        $route = Doctrine::getTable($model)->getOption('route');
        $column = $this->getIdentifier($model);
        $regexp = $this->getRegexForIdentifier($route);

      $module = $arguments['module'] ? $arguments['module'] : $name;
      $content = sprintf(<<<EOF
%s:
  class: sfRestRouteCollection
  options:
    model:                %s
    module:               %s
    prefix_path:          %s
    column:               %s
    with_wildcard_routes: true
  requirements:
    %s: "%s"

EOF
      , $name, $model, $module, $module, $column, $column, $regexp).$content;

      file_put_contents($routing, $content);
    }
        $finder = sfFinder::type('file')->name('*.php', '*.yml');

    $this->constants['CONFIG'] = sprintf(<<<EOF
    model_class:           %s
    theme:                 %s
    non_verbose_templates: %s
    singular:              %s
    plural:                %s
    route_prefix:          %s
    with_doctrine_route:     %s
EOF
    ,
      $arguments['model'],
      'api',
      $options['non-verbose-templates'] ? 'true' : 'false',
      $options['singular'] ? $options['singular'] : '~',
      $options['plural'] ? $options['plural'] : '~',
      $options['route-prefix'] ? $options['route-prefix'] : '~',
      $options['with-doctrine-route'] ? $options['with-doctrine-route'] : 'false'
    );
        $this->getFilesystem()->replaceTokens($finder->in($moduleDir), '##', '##', $constants);
    }


    protected function getIdentifier($model)
    {
        $id_column = Doctrine::getTable($model)->getIdentifier();
        if($id_column != null){
            return $id_column;
        }
        return 'id';
    }

    protected function getRegexForIdentifier($route)
    {
        if(isset($route['regexp'])){
            return $route['regexp'];
        }
        return '\d+';

    }
}