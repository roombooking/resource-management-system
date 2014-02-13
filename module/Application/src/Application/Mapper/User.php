<?php
namespace Application\Mapper;

use Application\Entity\User as UserEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class User extends TableGateway
{
    protected $tableName = 'Users';
    protected $idCol = 'userid';
    protected $entityPrototyp = null;
    protected $hydrator = null;
    
    public function __construct ($adapter)
    {
        parent::__construct($this->tableName, 
                $adapter, 
                new RowGatewayFeature($this->idCol)
        );
        $this->entityPrototyp = new UserEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    
    
    public function getAllUser() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    public function getUser($id) {
        return $this->hydrate(
                $this->select(array(
                        'id' => $id,
                ))
        );
    }
    
    public function getUser($prename,$lastname) {
    	return $this->hydrate(
    	        $this->select(array(
    	                'firstname' => $prename,
    	                'lastname'  => $lastname,
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
    
	public function update($entity) {
		return parent::update( 
		        $this->hydrator->extract($entity), 
		        $this->idCol . "=" . $entity->getId()
		);
	}
}