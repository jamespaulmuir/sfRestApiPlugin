[?php

/**
 * <?php echo $this->getModuleName() ?> actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php $
 */
class <?php echo $this->getGeneratedModuleName() ?>Actions extends BaseRestActions
{

<?php include dirname(__FILE__).'/../../parts/preExecute.php' ?>

<?php include dirname(__FILE__).'/../../parts/indexAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/showAction.php' ?>


<?php foreach($this->getAllManyToManyTables() as $table) {
    $relationAlias = ucfirst($table['alias']);
    include dirname(__FILE__).'/../../parts/relationAction.php';
    unset($relationAlias);
  }?>
}