<?php
namespace Application\Mapper;

use Application\Entity\Incident as IncidentEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class Incident extends TableGateway
{
    protected $tableName = 'Incidents';
    protected $idCol = 'incidentid';
    protected $entityPrototype = null;
    protected $hydrator = null;
    
    public function __construct($adapter)
    {
        parent::__construct($this->tableName, $adapter, new RowGatewayFeature($this->idCol));
        $this->entityPrototype = new IncidentEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    public function fetchAll() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    public function getIncident($id) {
        return $this->hydrate(
                $this->select(array(
                        $this->idCol => $id,
                ))
        );
    }
    
    public function insert($entity) {
        return parent::insert($this->hydrator->extract($entity));
    }

    public function hydrate($results) {
		$users = new \Zend\Db\ResultSet\HydratingResultSet( 
		        $this->hydrator,
				$this->entityPrototype
		);
		return $users->initialize($results->toArray());
    }
}