<?php
namespace Application\Mapper;

use Application\Entity\User as UserEntity;
use Application\Mapper\Role as RoleMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class User extends TableGateway
{
    protected $tableName = 'Users';
    protected $idCol = 'id';
    protected $entityPrototype = null;
    protected $hydrator = null;
    
    /**
     * Constructor
     * 
     * @param AdapterInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($this->tableName, 
                $adapter, 
                new RowGatewayFeature($this->idCol)
        );
        $this->entityPrototype = new UserEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }
    
    /**
     * Retrieves all Users in the Database
     * 
     * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
     */
    public function fetchAll() {
        return $this->hydrate(
        		$this->select()
        );
    }
    
    /**
     * 
     * @param int $id
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL, object, \ArrayObject, \Zend\Db\ResultSet\mixed, unknown, boolean>
     */
    public function fetchId($id) {
        $id = (int) $id;
        $rowset = $this->hydrate(
                $this->select(array(
                        'id' => $id,
                ))
        );
        $user = $rowset->current();
        if (!$user) {
        	throw new \Exception("Could not find user with ID: $id");
        }
        
        return $user;
    }
    
    public function fetchName($prename,$lastname) {
    	$rowset = $this->hydrate(
    	        $this->select(array(
    	                'firstname' => $prename,
    	                'lastname'  => $lastname,
    	        ))
    	);

    	$user = $rowset->current();
    	if (!$user) {
    		throw new \Exception("Could not find user named: $prename $lastname");
    	}
    	
    	return $user;
    }
    
    public function fetchLdapId($ldapId) {
        $rowset = $this->hydrate(
                $this->select(array(
                        'ldap_id' => $ldapId,
                ))
        );
        $user = $rowset->current();
        if (!$user) {
        	throw new \Exception("Could not find user with LdapID: $ldapId");
        }
        
        return $user;
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