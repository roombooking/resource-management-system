<?php
namespace Application\Mapper;

use Application\Entity\User as UserEntity;
use Application\Mapper\Role as RoleMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

/**
 * User Mapper
 *
 * The incident mapper maps entities of the type Application\Entity\User
 * to their represenations in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class User extends TableGateway
{
    protected $tableName = 'Users';
    protected $idCol = 'userid';
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
    public function fetchAll($order = false, $deleted = false) {
        $select = $this->select(function ($select) use ($order, $deleted) {
            if($deleted === true) $select->where(array('isdeleted' => 1));
            if($order === true) $select->order('lastname ASC');
        });
        
        return $this->hydrate(
                $select
        );
    }
    
    /**
     * Fetches a user with a given id.
     * 
     * @param int $id The id of the user entity to fetch.
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL, object, \ArrayObject, \Zend\Db\ResultSet\mixed, unknown, boolean>
     */
    public function fetchId($id) {
        $id = (int) $id;
        $rowset = $this->hydrate(
                $this->select(array(
                        'userid' => $id,
                ))
        );
        $user = $rowset->current();
        if (!$user) {
        	throw new \Exception("Could not find user with ID: $id");
        }
        
        return $user;
    }
    
    /**
     * Fetches a user based on her/his given name and surname.
     * 
     * @param string $prename The given name of the user.
     * @param string $lastname The surname of the user.
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL, object, \ArrayObject, \Zend\Db\ResultSet\mixed, unknown, boolean>
     */
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
    
    /**
     * Fetches a user with a given LDAP id.
     * 
     * @param string $ldapId The LDAP id of the user.
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL, object, \ArrayObject, \Zend\Db\ResultSet\mixed, unknown, boolean>
     */
    public function fetchLdapId($ldapId) {
        $rowset = $this->hydrate(
                $this->select(array(
                        'ldapid' => $ldapId,
                ))
        );
        $user = $rowset->current();
        if (!$user) {
        	throw new \Exception("Could not find user with LdapID: $ldapId");
        }
        
        return $user;
    }
    
    /**
     * Inserts a new user to the database.
     * 
     * @param Application\Entity\User $entity The user entity to inser.
     * 
     * (non-PHPdoc)
     * @see \Zend\Db\TableGateway\AbstractTableGateway::insert()
     */
    public function insert($entity) {
        return parent::insert($this->hydrator->extract($entity));
    }
    
    /**
     * 
     * Updates a given user in the database.
     * 
     * @param Application\Entity\User $entity The user entity to update.
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