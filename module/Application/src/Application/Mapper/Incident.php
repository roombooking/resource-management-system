<?php
namespace Application\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
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
class Incident
{
    /**
     * DB Adapter
     *
     * @var AdapterInterface $adapter
     */
    private $adapter;
    
    /**
     * Hydrator
     *
     * @var HydratorInterface $hydrator
     */
    private $hydrator;
    
    /**
     * 
     * @param AdapterInterface $adapter
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
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
         $select = new Select('Incidents');
         $select->order('incidentid DESC');
         // create a new result set based on the Incident entity
         $resultSet = new HydratingResultSet($this->hydrator, new IncidentEntity());
         // create a new pagination adapter object
         $paginatorAdapter = new DbSelect(
             // our configured select object
             $select,
             // the adapter to run it against
             $this->adapter,
             // the result set to hydrate
             $resultSet
         );
         $paginator = new Paginator($paginatorAdapter);
         return $paginator;
     }
}