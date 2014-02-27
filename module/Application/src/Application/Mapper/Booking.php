<?php
namespace Application\Mapper;

use Application\Entity\Booking as BookingEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;

class Booking extends TableGateway
{
    protected $tableName = 'Bookings';
    protected $idCol = 'bookingid';
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
        $this->entityPrototype = new BookingEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }
    
    public function fetchBookings($start, $end) {
    	$rowset = $this->hydrate(
    	        $this->select(array(
    	                /*
    	                 * FIXME XXX Hier richtiges Query.
    	                 */
    	                'isdeleted'  => false
    	        ))
    	);
    	
    	return $rowset;
    }


    public function hydrate($results) {
        
		$users = new \Zend\Db\ResultSet\HydratingResultSet( 
		        $this->hydrator,
				$this->entityPrototype
		);
		
		return $users->initialize($results->toArray());
    }
}
?>