<?php
namespace Application\Mapper;

use Application\Entity\Power as PowerEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

/**
 * Power Mapper
 *
 * The incident mapper maps entities of the type Application\Entity\Power
 * to their represenations in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Power extends TableGateway
{
    protected $tableName = 'Powers';
    protected $idCol = 'powerid';
    protected $entityPrototype = null;
    protected $hydrator = null;
    
    /**
     * 
     * @param AdapterInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($this->tableName, 
                $adapter, 
                new RowGatewayFeature($this->idCol)
        );
        $this->entityPrototype = new PowerEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    /**
     * Fetches all powers from the database.
     * 
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function fetchAll($order = false) {
        $select = $this->select(function ($select) use ($order) {
        	if($order === true) $select->order('roleid, action ASC');
        });
        
        return $this->hydrate(
        		$select
        );
    }
    
    /**
     * Fetches a power with a given id from the database.
     * 
     * @param int $id The id of the power to fetch.
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function getId($id) {
        return $this->hydrate(
                $this->select(array(
                        $this->idCol => $id,
                ))
        );
    }
    
    /**
     * Inserts a power into the database.
     * 
     * @param Application\Entity\Power $entity The power entity to insert.
     * 
     * (non-PHPdoc)
     * @see \Zend\Db\TableGateway\AbstractTableGateway::insert()
     */
    public function insert($entity) {
        return parent::insert($this->hydrator->extract($entity));
    }
    
    /**
     * Updates a power in the database.
     * 
     * @param Application\Entity\Power $entity The power to update. 
     * @return Ambigous <number, \Zend\Db\TableGateway\mixed>
     */
    public function updateEntity($entity) {
    	return parent::update(
    			$this->hydrator->extract($entity),
    			$this->idCol . "=" . $entity->getPowerId()
    	);
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
    
    public function deletePowerById($id) {
    	if(is_int($id) && $id > 0) {
    		return $this->delete(array($this->idCol => $id));
    	} else {
    		throw new \Exception('ID is not an integer!');
    	}
    }
}