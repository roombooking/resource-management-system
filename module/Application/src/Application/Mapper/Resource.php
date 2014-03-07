<?php
namespace Application\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Application\Entity\Containment as ConatinmentEntity;


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
	
	public function fetchAllContainments()
	{
		$entity = new ConatinmentEntity();
		$statement = $this->adapter->createStatement();
		
		/*
		 * Get all non-deleted resources with their containments
		 */
		$statement->prepare("SELECT r.resourceid AS r_resourceid, r.isbookable AS r_isbookable, r.name AS r_name, r.description AS r_description, r.color AS r_color, p.placeid AS p_placeid, e.equipmentid AS e_equipmentid, c.hirachyid AS c_hirachyid, c.parent AS c_parent, c.name AS c_name, c.description AS c_description, h.hirachyid AS h_hirachyid FROM Resources r LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child LEFT OUTER JOIN Hirachies h ON c.hirachyid = h.hirachyid WHERE r.isdeleted != 1 ORDER BY h.hirachyid ASC, r.resourceid ASC;");
	
		$result = $statement->execute();
	
		$resultSet = new HydratingResultSet($this->hydrator, $entity);
	
		return $resultSet->initialize($result);
	}

}
?>