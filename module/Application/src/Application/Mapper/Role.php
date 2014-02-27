<?php
namespace Application\Mapper;

use Application\Entity\Role as RoleEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class Role extends TableGateway
{
    protected $tableName = 'Roles';
    protected $idCol = 'roleid';
    protected $entityPrototype = null;
    protected $hydrator = null;
    
    public function __construct($adapter)
    {
        parent::__construct($this->tableName, 
                $adapter, 
                new RowGatewayFeature($this->idCol)
        );
        $this->entityPrototype = new RoleEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection();
    }
    
    
    
    public function fetchAll() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    public function getRole($id) {
        return $this->hydrate(
                $this->select(array(
                        'roleid' => $id,
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
    
	public function updateEntity($entity) {
		return parent::update( 
		        $this->hydrator->extract($entity), 
		        $this->idCol . "=" . $entity->getId()
		);
	}
}