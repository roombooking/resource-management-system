<?php
namespace Application\Mapper;

use Application\Entity\Booking as BookingEntity;
use Application\Entity\MinimalBooking as MinimalBookingEntity;
use Zend\Db\ResultSet\HydratingResultSet;

class Booking
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

    public function fetchBookingsByStartEnd ($start, $end)
    {
        $entity = new MinimalBookingEntity();
        $statement = $this->adapter->createStatement();
        
        /*
         * This query should return the minimum information necessary for the full calendar.
         * It should run fast and only on the 'Bookings' table.
         * In-depth data that needs to be joined will be selected on a per-item base later
         * for better performance.
         */
        $statement->prepare("SELECT b.name AS b_name, DATE_FORMAT(b.start, '%Y-%m-%dT%TZ') AS b_start, DATE_FORMAT(b.end, '%Y-%m-%dT%TZ') AS b_end, b.isprebooking AS b_isprebooking, b.bookingid AS b_bookingid, b.resourceid AS b_resourceid, r.color AS r_color FROM Resources r RIGHT OUTER JOIN Bookings b ON r.resourceid = b.resourceid WHERE ( (UNIX_TIMESTAMP(b.start) >= " . $start . " AND UNIX_TIMESTAMP(b.start) <= " . $end . ") OR (UNIX_TIMESTAMP(b.end) >= " . $start . " AND UNIX_TIMESTAMP(b.end) <= " . $end . ") ) AND b.isdeleted = false;");
        
        $result = $statement->execute();
        
        $resultSet = new HydratingResultSet($this->hydrator, $entity);
        
        return $resultSet->initialize($result);
    }
    
    public function fetchBookingsById ($id)
    {
        $entity = new BookingEntity();
        
    	$statement = $this->adapter->createStatement();
    	$statement->prepare("SELECT b.bookingid AS b_bookingid, b.name AS b_name, b.description AS b_description, b.participant_description AS b_participant_description, DATE_FORMAT(b.start, '%Y-%m-%dT%TZ') AS b_start, DATE_FORMAT(b.end, '%Y-%m-%dT%TZ') AS b_end, b.isprebooking AS b_isprebooking, b.isdeleted AS b_isdeleted, u_r.userid AS u_r_userid, u_r.roleid AS u_r_roleid, u_r.ldapid AS u_r_ldapid, u_r.loginname AS u_r_loginname, u_r.firstname AS u_r_firstname, u_r.lastname AS u_r_lastname, u_r.emailaddress AS u_r_emailaddress, u_b.userid AS u_b_userid, u_b.ldapid AS u_b_ldapid, u_b.loginname AS u_b_loginname, u_b.firstname AS u_b_firstname, u_b.lastname AS u_b_lastname, u_b.emailaddress AS u_b_emailaddress, r.resourceid AS r_resourceid, r.isbookable AS r_isbookable, r.isdeleted AS r_isdeleted, r.name AS r_name, r.description AS r_description, r.color AS r_color, u_b.roleid AS u_b_roleid, e.equipmentid AS e_equipmentid, p.size AS p_size, p.seatnumber AS p_seatnumber, p.placeid AS p_placeid, c.containmentid AS c_containmentid, c.parent AS c_parent, c.name AS c_name, c.description AS c_description, h.hierarchyid AS h_hierarchyid FROM Users u_b RIGHT OUTER JOIN Bookings b ON u_b.userid = b.booking_userid LEFT OUTER JOIN Users u_r ON b.responsible_userid = u_r.userid LEFT OUTER JOIN Resources r ON b.resourceid = r.resourceid LEFT OUTER JOIN Equipments e ON r.resourceid = e.resourceid LEFT OUTER JOIN Places p ON r.resourceid = p.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child LEFT OUTER JOIN Hierarchies h ON c.hierarchyid = h.hierarchyid WHERE b.bookingid = " . $id . ";");
    
    	$result = $statement->execute();
    
    	$resultSet = new HydratingResultSet($this->hydrator, $entity);
    
    	return $resultSet->initialize($result);
    }
    
    public function fetchCollidingBookings ($hierarchyid, $resourceid, $start, $end)
    {
    	$entity = new MinimalBookingEntity();
    
    	$statement = $this->adapter->createStatement();
    	$statement->prepare("SELECT b.name AS b_name, DATE_FORMAT ( b.start , '%Y-%m-%dT%TZ' ) AS b_start, DATE_FORMAT ( b.end , '%Y-%m-%dT%TZ' ) AS b_end, b.isprebooking AS b_isprebooking, b.bookingid AS b_bookingid, b.resourceid AS b_resourceid, r.color AS r_color FROM Resources r RIGHT OUTER JOIN Bookings b ON r.resourceid = b.resourceid LEFT OUTER JOIN Containments c ON r.resourceid = c.child WHERE ((UNIX_TIMESTAMP(b.start) >= " . $start . " AND UNIX_TIMESTAMP(b.start) <= " . $end . ") OR (UNIX_TIMESTAMP(b.end) >= " . $start . " AND UNIX_TIMESTAMP(b.end) <= " . $end . ")) AND r.resourceid = " . $resourceid . " AND c.hierarchyid = " . $hierarchyid . " AND b.isdeleted = false AND b.isprebooking = false;");
    
    	$result = $statement->execute();
    
    	$resultSet = new HydratingResultSet($this->hydrator, $entity);
    
    	return $resultSet->initialize($result);
    }
    
    public function insert($entity) {
        $statement = $this->adapter->createStatement();
        $statement->prepare("INSERT INTO roombooking.Bookings (booking_userid, responsible_userid, resourceid, name, description, participant_description, start, end, isprebooking, isdeleted) VALUES(" . $entity->getu_b_userid() . ", " . ($entity->getu_r_userid() == "" ? "null" : $entity->getu_r_userid()) . ", " . $entity->getr_resourceid() . ", '" . mysqli_real_escape_string($entity->getb_name()) . "', '" . mysqli_real_escape_string($entity->getb_description()) . "', '" . mysqli_real_escape_string($entity->getb_participant_description()) . "', FROM_UNIXTIME(" . $entity->getb_start() . "), FROM_UNIXTIME(" . $entity->getb_end() . "), " . $entity->getb_isprebooking() . ", 00);");
        return $statement->execute();
    }
}
?>