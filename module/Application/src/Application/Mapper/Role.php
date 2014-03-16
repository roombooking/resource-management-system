<?php
namespace Application\Mapper;

use Application\Entity\Role as RoleEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

/**
 * Role Mapper
 *
 * The incident mapper maps entities of the type Application\Entity\Role
 * to their represenations in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Role extends TableGateway
{
    protected $tableName = 'Roles';
    protected $idCol = 'roleid';
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
        $this->entityPrototype = new RoleEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    /**
     * Fetches all roles from the database.
     * 
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function fetchAll() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    /**
     * Fetches a role with a given id from the database.
     * 
     * @param int $id The id of the role to fetch.
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function getRole($id) {
        return $this->hydrate(
                $this->select(array(
                        $this->idCol => $id,
                ))
        );
    }
    
    /**
     * Inserts a given role into the database.
     * 
     * @param Application\Entity\Role $entity The role entity to insert.
     * 
     * (non-PHPdoc)
     * @see \Zend\Db\TableGateway\AbstractTableGateway::insert()
     */
    public function insert($entity) {
        return parent::insert($this->hydrator->extract($entity));
    }
    
    /**
     * Inserts a given role in the database.
     * 
     * @param Application\Entity\Role $entity The role entity to update.
     * @return Ambigous <number, \Zend\Db\TableGateway\mixed>
     */
    public function updateEntity($entity) {
    	return parent::update(
    			$this->hydrator->extract($entity),
    			$this->idCol . "=" . $entity->getId()
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
    

}