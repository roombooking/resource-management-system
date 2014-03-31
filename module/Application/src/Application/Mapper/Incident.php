<?php
namespace Application\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Application\Entity\Incident as IncidentEntity;


/**
 * Incident Mapper
 *
 * The incident mapper maps entities of the type Application\Entity\Incident
 * to their represenations in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Incident extends TableGateway
{
    protected $tableName = 'Incidents';
    protected $idCol = 'incidentid';
    protected $entityPrototype = null;
    protected $hydrator = null;
    
    /**
     * 
     * @param AdapterInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($this->tableName, $adapter, new RowGatewayFeature($this->idCol));
        $this->entityPrototype = new IncidentEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    /**
     * Fetches all incidents from the database.
     * 
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
     public function fetchAll()
     {
          // create a new Select object for the table Incident
         $select = new Select($this->tableName);
         $select->order('incidentid DESC');
         // create a new result set based on the Incident entity
         $resultSet = new HydratingResultSet($this->hydrator, $this->entityPrototype);
         // create a new pagination adapter object
         $paginatorAdapter = new DbSelect(
             // our configured select object
             $select,
             // the adapter to run it against
             $this->getAdapter(),
             // the result set to hydrate
             $resultSet
         );
         $paginator = new Paginator($paginatorAdapter);
         return $paginator;
     }
     
     /**
      * Inserts an incident into the database.
      *
      * @param Application\Entity\Incident $entity The incident entity to insert.
      *
      * (non-PHPdoc)
      * @see \Zend\Db\TableGateway\AbstractTableGateway::insert()
      */
     public function insert($entity) {
     	return parent::insert($this->hydrator->extract($entity));
     }
     
     /**
      * Hydrates the results to a resultset.
      *
      * @param unknown $results
      * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
      */
     public function hydrate($results) {
     	$users = new \Zend\Db\ResultSet\HydratingResultSet(
     			$this->hydrator,
     			$this->entityPrototype
     	);
     	return $users->initialize($results->toArray());
     }
}