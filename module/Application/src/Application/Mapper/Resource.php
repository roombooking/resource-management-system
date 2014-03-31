<?php
namespace Application\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Application\Entity\Containment as ContainmentEntity;
use Application\Entity\Hierarchy as HierarchyEntity;
use Application\Entity\Resource as ResourceEntity;

/**
 * Resource Mapper
 *
 * The incident mapper maps entities of the type Application\Entity\Containment,
 * Application\Entity\Hierarchy and Application\Entity\Resource to their
 * represenations in the database.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Resource
{
	/**
	 * Constructor
	 *
	 * @param AdapterInterface $adapter
	 */
	public function __construct($adapter)
	{
		$this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
		$this->adapter = $adapter;
	}
	
	/**
	 * Fetches all containments from the database.
	 * 
	 * TODO make this SQL injection safe
	 * 
	 * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
	 */
	public function fetchAllContainments()
	{
		$entity = new ContainmentEntity();
		$statement = $this->adapter->createStatement();
		
		/*
		 * Get all non-deleted resources with their containments
		 */
		$statement->prepare("SELECT r.resourceid AS r_resourceid, r.isbookable AS r_isbookable, r.name AS r_name, r.description AS r_description, r.color AS r_color, p.placeid AS p_placeid, e.equipmentid AS e_equipmentid, c.hierarchyid AS c_hierarchyid, c.parent AS c_parent, c.name AS c_name, c.description AS c_description, h.hierarchyid AS h_hierarchyid FROM Resources r LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child LEFT OUTER JOIN Hierarchies h ON c.hierarchyid = h.hierarchyid WHERE r.isdeleted != 1 ORDER BY h.hierarchyid ASC, r.resourceid ASC;");
	
		$result = $statement->execute();
	
		$resultSet = new HydratingResultSet($this->hydrator, $entity);
	
		return $resultSet->initialize($result);
	}
	
	/**
	 * Fetches a containment with a given id.
	 * 
	 * TODO make this SQL injection safe
	 * 
	 * @param int $id The id of the containment to get.
	 * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
	 */
	public function fetchContainmentsById($id)
	{
		$entity = new ContainmentEntity();
	
		/*
		 * Get all non-deleted resources with $id with their containments
		 */
		$sql = "SELECT r.resourceid AS r_resourceid, r.isbookable AS r_isbookable, r.name AS r_name, r.description AS r_description, r.color AS r_color, p.placeid AS p_placeid, e.equipmentid AS e_equipmentid, c.hierarchyid AS c_hierarchyid, c.parent AS c_parent, c.name AS c_name, c.description AS c_description, h.hierarchyid AS h_hierarchyid FROM Resources r LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child LEFT OUTER JOIN Hierarchies h ON c.hierarchyid = h.hierarchyid WHERE r.isdeleted != 1 AND h.hierarchyid = ? ORDER BY r.resourceid ASC";
        $parameters = array(
        	$id
        );
		
		$statement = $this->adapter->createStatement($sql);
		$result = $statement->execute($parameters);
	
		$resultSet = new HydratingResultSet($this->hydrator, $entity);
	
		return $resultSet->initialize($result);
	}
	
	/**
	 * Fetches all hierarchies.
	 * 
	 * TODO make this SQL injection safe
	 * 
	 * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
	 */
	public function fetchAllHierarchies() {
	    $entity = new HierarchyEntity();
	    $statement = $this->adapter->createStatement();
	    
	    /*
	     * Get all hierarchies
	     */
	    $statement->prepare("SELECT h.hierarchyid AS h_hierarchyid, h.name AS h_name FROM Hierarchies h;");
	    
	    $result = $statement->execute();
	    
	    $resultSet = new HydratingResultSet($this->hydrator, $entity);
	    
	    return $resultSet->initialize($result);
	}
	
	/**
	 * Fetches a resource by id of the resource and the id
	 * of the hierarchy containing it.
	 * 
	 * @param int $hierarchyid The id of the hierarchy.
	 * @param int $resourceid The id of the resource.
	 * @return Ambigous <\Zend\Db\ResultSet\ResultSet, \Zend\Db\ResultSet\HydratingResultSet>
	 */
	public function fetchResourceByIds($hierarchyid, $resourceid) {
	    $entity = new ContainmentEntity();
	    
	    $sql = "SELECT r.resourceid AS r_resourceid, r.isbookable AS r_isbookable, r.isdeleted AS r_isdeleted, r.name AS r_name, r.description AS r_description, r.color AS r_color, p.placeid AS p_placeid, e.equipmentid AS e_equipmentid, c.hierarchyid AS c_hierarchyid, c.parent AS c_parent, c.name AS c_name, c.description AS c_description, h.hierarchyid AS h_hierarchyid FROM Resources r LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child LEFT OUTER JOIN Hierarchies h ON c.hierarchyid = h.hierarchyid WHERE r.isdeleted != 1 AND r.resourceid = ? AND c.hierarchyid = ?";
	    $parameters = array(
                $resourceid,
                $hierarchyid
	    );    
	    
	    $statement = $this->adapter->createStatement($sql);
	    $result = $statement->execute($parameters);
	    
	    $resultSet = new HydratingResultSet($this->hydrator, $entity);
	    
	    return $resultSet->initialize($result);
	}

	public function insertResource(ContainmentEntity $entity, $resourceType = null) {
	    $sql = "INSERT INTO Resources (name, description, isbookable, color) VALUES ( ?, ?, ?, ? );";
	    $parameters = array(
	    		$entity->getr_name(),
	    		$entity->getr_description(),
	    		(int) $entity->getr_isbookable(),
	    		$entity->getr_color()
	    );
	    $resourceId = null;

    	$statement = $this->adapter->createStatement($sql);
    	$rslt = $statement->execute($parameters);
    	
    	$resourceId = (int) $this->adapter->getDriver()->getLastGeneratedValue();
    	
    	if($resourceId > 0) {
    	    
    	    $statement = $this->adapter->createStatement("INSERT INTO Containments ( hierarchyid, parent, child ) VALUES ( ?, ?, ? )");
    	    $rslt = $statement->execute(array($entity->getc_hierarchyid(), $entity->getc_parent(), $resourceId));	    	    
    	    
    		$filter = new \Zend\Filter\StripTags();
    		$resourceType = $filter->filter($resourceType);
    		if($resourceType == "room") {
    			$statement = $this->adapter->createStatement("INSERT INTO Places (resourceid) VALUES ( ? )");
    			$rslt = $statement->execute(array($resourceId));
    			 
    		} elseif ($resourceType == "equipment") {
    			$statement = $this->adapter->createStatement("INSERT INTO Equipments (resourceid) VALUES ( ? )");
    			$rslt = $statement->execute(array($resourceId));
    			 
    		} else {
    			$this->deleteResourceById($resourceId);
    			throw new \Exception('Unknown Resource Type for "'. $entity->getr_name() .' (Type: '. $resourceType .')". Resource has been deleted!');
    		}
    		return $resourceId;
    	}
    	    
	    return null;
	}
	
	public function editResource(ContainmentEntity $entity, $resourceType = null) {
        $oldEntity = $this->fetchResourceByIds($entity->getc_hierarchyid(), $entity->getr_resourceid())->current();
	    
	    
	    $sql = "UPDATE Resources SET name = ?, description = ?, isbookable = ?, color = ? WHERE resourceid = ?";
	    $parameters = array(
	    		$entity->getr_name(),
	    		$entity->getr_description(),
	    		(int) $entity->getr_isbookable(),
	    		$entity->getr_color(),
	            $entity->getr_resourceid()
	    );
	    
	    $statement = $this->adapter->createStatement($sql);
	    $rslt = $statement->execute($parameters);
		
    	$filter = new \Zend\Filter\StripTags();
    	$resourceType = $filter->filter($resourceType);
    	if($resourceType == "room" && ($oldEntity->gete_equipmentid() !== null)) {
    	    $statement = $this->adapter->createStatement("DELETE FROM Equipments WHERE resourceid = ?");
    	    $rslt = $statement->execute(array($entity->getr_resourceid()));
    	    
    		$statement = $this->adapter->createStatement("INSERT INTO Places (resourceid) VALUES ( ? )");
    		$rslt = $statement->execute(array($entity->getr_resourceid()));
    	} elseif ($resourceType == "equipment" && ($oldEntity->getp_placeid() !== null)) {
    	    $statement = $this->adapter->createStatement("DELETE FROM Places WHERE resourceid = ?");
    	    $rslt = $statement->execute(array($entity->getr_resourceid()));
    	    
    		$statement = $this->adapter->createStatement("INSERT INTO Equipments (resourceid) VALUES ( ? )");
    		$rslt = $statement->execute(array($entity->getr_resourceid()));
    	} 
    	
    	if($resourceType != "room" && $resourceType != "equipment") {
    		throw new \Exception('Unknown Resource Type for "'. $entity->getr_name() .' (Type: '. $resourceType .')". Resource Type has not been edit!');
    	}
    	
    	return true;
	}
	
	public function updatePosition($resourceId, $newParentId) {
	    if((is_int($resourceId) && $resourceId > 0) && (is_int($newParentId) && $newParentId > 0)) {
	       $statement = $this->adapter->createStatement("UPDATE Containments set parent = ?  WHERE child = ?;");
	       $rslt = $statement->execute(array($newParentId, $resourceId));
	       return true;
	    } else {
	        throw new \Exception('Both IDs must be an integer!');
	    }
	}
	
	public function deleteResourceById($id) {
        if(is_int($id) && $id > 0) {
	       $statement = $this->adapter->createStatement("UPDATE Resources set isdeleted = 1 WHERE resourceid = ?");
	       $rslt = $statement->execute(array($id));
	       return true;
        } else {
            throw new \Exception('ID is not an integer!');
        }
	}
}
?>