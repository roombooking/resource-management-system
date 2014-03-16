<?php
namespace Application\Mapper;

use Application\Entity\Incident as IncidentEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

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
    public function fetchAll() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    /**
     * Fetches an incident with a given id from the database.
     * 
     * @param int $id The id of the incident to fetch.
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function getIncident($id) {
        return $this->hydrate(
                $this->select(array(
                        $this->idCol => $id,
                ))
        );
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