<?php

class sfRestGenerator extends sfDoctrineGenerator
{
    public function initialize(sfGeneratorManager $generatorManager)
    {
        parent::initialize($generatorManager);

        $this->setGeneratorClass('sfRestPlugin');
    }

 /**
   * Returns an array of tables that represents a many to many relationship.
   *
   * A table is considered to be a m2m table if it has 2 foreign keys that are also primary keys.
   *
   * @return array An array of tables.
   */
  public function getAllManyToManyTables()
  {
    $relations = array();
    foreach ($this->table->getRelations() as $relation)
    {
      if ($relation->getType() === Doctrine_Relation::MANY)
      {
        $relations[] = $relation;
      }
    }
    return $relations;
  }

    public function getOneToManyFields()
    {
        $relations = array();
        foreach ($this->table->getRelations() as $relation)
        {
          if ($relation->getType() === Doctrine_Relation::ONE)
          {
            $relations[] = $relation;
          }
        }
        return $relations;
    }
}
